<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\PackageInterface;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MassifController extends AbstractController implements PackageInterface
{
    /**
     * @Route("/massif", name="app_massif",methods={"GET"})
     */
    public function index(): Response
    {
        $package=new Package(new EmptyVersionStrategy());
        //$package = new Symfony\Component\Asset\Package(new EmptyVersionStrategy());
        $path = $package->getUrl('massifs.json');
        $data = file_get_contents($path);
        $jsonData = json_decode($data,1);
        return $this->json($jsonData,200);
    }

    /**
     * @Route("/getMassifRegion", name="getMassifRegion",methods={"GET","POST"})
     */
    public function getMassifRegion(Request $request): Response
    {
        $package=new Package(new EmptyVersionStrategy());
        //$package = new Symfony\Component\Asset\Package(new EmptyVersionStrategy());
        $path = $package->getUrl('massifs.json');
        $data = file_get_contents($path);
        $jsonData = json_decode($data,1);
        $massifs=[];
        $content=$request->getContent();
        $form=json_decode($content,true);
        $i=0;
        for ($i=0;$i<count($jsonData);$i++){
            if ($jsonData[$i]['region']==$form['region']){
                $massifs[]=$jsonData[$i];
            }
            $i++;
        }
        return $this->json($massifs,200);
    }
    /**
     * @Route("/createMassif", name="createMassif", methods={"GET","POST"})
     */
    public function create(Request $request)
    {
        $content=$request->getContent();
        $form=json_decode($content,true);
        $inp = file_get_contents('massifs.json');
        $tempArray = json_decode($inp);
        array_push($tempArray, $form[0]);
        $jsonData = json_encode($tempArray);
        file_put_contents('massifs.json', $jsonData);
        return $this->json($form,200);
    }
    public function getVersion(string $path)
    {
        // TODO: Implement getVersion() method.
    }

    public function getUrl(string $path)
    {
        // TODO: Implement getUrl() method.
    }
}

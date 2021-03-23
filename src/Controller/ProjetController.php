<?php

namespace App\Controller;
use App\Entity\Client;
use App\Entity\Facturation;
use App\Entity\Vehicule;
use App\Form\NewVoitureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\RegistrationType;
use App\Form\SelectionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProjetController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index( )
    {
        $repo = $this->getDoctrine()->getRepository(Vehicule::class);
        $voiture = $repo->findAll();
 
        return $this->render('projet/index.html.twig', [
            'voitures' => $voiture
        ]);
    }

        /**
     * @Route("/sucsses", name="sucsses")
     */
    public function Bravo( )
    {

       return $this->render('projet/Succses.html.twig');
    }
    /**
     * @Route("/inscription", name="Registration")
     */
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $client = new Client;

        $form = $this->createForm(RegistrationType::class, $client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($client, $client->getPassword());
            $client->setMdp($hash);
            if ($client->RolesButton) {
                $client->setRoles(['ROLE_CLIENT']);
            } else
            {
                $client->setRoles(['ROLE_LOUEUR']);
            }
            $manager->persist($client);
            $manager->flush();
            return $this->redirectToRoute('login');
        }
        return $this->render('projet/Inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/login", name="login")
     */
    public function login(){
        return $this->render('projet/Connection.html.twig');
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){
        return $this->render('projet/logout.html.twig');
    }

     /**
     * @IsGranted("ROLE_CLIENT", statusCode=404, message="Page non trouvée")
     * @Route("/Ma_flotte", name="flotte")
     */
    public function flotte(){
       $idU= $this->getUser()->getId();
        $rep = $this->getDoctrine()->getRepository(Facturation::class);
        $factures = $rep->findBy(['ide'=>$idU]);
        return $this->render('projet/flotte.html.twig', [
            'factures' => $factures
        ]);  
    }

     /**
     * @IsGranted("ROLE_CLIENT", statusCode=404, message="Page non trouvée")
     * @Route("/Location", name="location")
     */
    public function Brasvo( )
    {

       return $this->render('projet/Succses.html.twig');
    }

//     public function location(Request $request, EntityManagerInterface $manager){
        
//         $idU= $this->getUser()->getId();
//         $repo = $this->getDoctrine()->getRepository(Vehicule::class);
//         $voiture = $repo->findBy(['location'=>'disponible']);
//         foreach ($voiture as $v) {
//             $form = $this->createForm(SelectionType::class, $v);
//         }
//         $facture = new Facturation;
//         $form->handleRequest($request);
//         if ($form->isSubmitted()) {
//             foreach ($voiture as $vehicule) {
//             if ( $form->submit) {
//                 $vehicule->setLocation($idU);
//                 $facture->setIde($idU);
//                 $date=new \DateTime();
//                 $facture->setDateD($date);
//                 $date->modify('+1 month');
//                 $facture->setDateF($date);
//                 $facture->setIdv($vehicule->getId);
//                 $facture->setValeur(2121);
//                 $facture->setEtat('pas de reglement');
//                 $manager->persist($facture);
//             }
//         }
    
//             $manager->flush();
//             return $this->redirectToRoute('sucsses');
//         }
        

//         return $this->render('projet/location.html.twig',[
//             'voitures'=>$voiture,
//             'form' => $form->createView() ]);
    
// }
     /**
     * @IsGranted("ROLE_LOUEUR", statusCode=404, message="Page non trouvée")
     * @Route("/Nouvelle_Vehicule", name="NVehicule")
     */
    public function NewVehicule(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger){
        $voiture = new Vehicule;

        $form = $this->createForm(NewVoitureType::class, $voiture);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
             /** @var UploadedFile $PhotoFile */
             $PhotoFile = $form->get('PhotoATelecharge')->getData();
        if ($PhotoFile) {
            $originalFilename = pathinfo($PhotoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$PhotoFile->guessExtension();
            try {
                $PhotoFile->move(
                    $this->getParameter('Photo_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
            }
            $voiture->setPhoto($newFilename);
        }
            $manager->persist($voiture);
            $manager->flush();
            return $this->redirectToRoute('sucsses');
        }

        return $this->render('projet/NouvellesVoitures.html.twig', [
            'form' => $form->createView()
        ]);
    }
     /**
     * @IsGranted("ROLE_LOUEUR", statusCode=404, message="Page non trouvée")
     * @Route("/Location_Loueur", name="LocationLo")
     */
    public function location_Loueur(){
        $rep = $this->getDoctrine()->getRepository(Facturation::class);
        $DateActuel=new \DateTime();
        $factures = $rep->findBy(['dateD'< $DateActuel ,
        'dateF' > $DateActuel || 'dateF'=>null ]);
        return $this->render('projet/LocationsLoueur.html.twig', [
            'factures' => $factures
        ]);  
    }
     /**
     * @IsGranted("ROLE_LOUEUR", statusCode=404, message="Page non trouvée")
     * @Route("/Factures_Loueur", name="FacturesLo")
     */
    public function Factures_Loueur(){
        $repo = $this->getDoctrine()->getRepository(Client::class);
        $clients = $repo->findAll();
        $rep = $this->getDoctrine()->getRepository(Facturation::class);
        $DateActuel=new \DateTime();
        $factures = $rep->findBy(['dateD'< $DateActuel ,
        'dateF' > $DateActuel || 'dateF'=>null ]);
        return $this->render('projet/FacturesLoueur.html.twig', [
            'factures' => $factures,
            'clients'=> $clients
        ]);  
    }
     /**
     * @IsGranted("ROLE_LOUEUR", statusCode=404, message="Page non trouvée")
     * @Route("/Mon_Stock", name="StockVehicules")
     */
    public function Stock_Vehicules(){
        $repo = $this->getDoctrine()->getRepository(Vehicule::class);
        $voiture = $repo->findAll();
        return $this->render('projet/VehiculesLoueur.html.twig', [
            'voitures' => $voiture
        ]);
    }
     /**
     * @IsGranted("ROLE_LOUEUR", statusCode=404, message="Page non trouvée")
     * @Route("/Retraite_Vehicules", name="RetraiteVehicules")
     */
    public function RetraiteV(Request $request){
        $NomEntreprise ="";
for ($i=0; $i < ; $i++) { 
if(1==1){
    
}
else{
    1;
}

}
        $form = $this->createFormBuilder($NomEntreprise)
        ->add('Entreprise', TextType::class)
        ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $rep = $this->getDoctrine()->getRepository(Facturation::class);
            $factures = $rep->findBy(['ide.nom'=>$NomEntreprise]);
            return $this->render('projet/FactureUneEntreprise.html.twig', [
                'factures' => $factures
            ]);
        }
        return $this->render('projet/FacturesParEntreprise.html.twig', [
            'form' => $form->createView()
        ]);
    }    

    
}
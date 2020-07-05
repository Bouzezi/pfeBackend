<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use symfony\component\optionsresolver\optionsresolverinterface;

class AuthController extends AbstractController
{

    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $data = json_decode($request->getContent(),true);
        $username = $data['username'];
        $password = $data['password'];
        
        $user = new User($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $em->persist($user);
        $em->flush();

        return new Response(sprintf('User %s successfully created', $user->getUsername()));
    }
    public function changerPassword(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        
        $data = json_decode($request->getContent(),true);
        $username = $data['username'];
        $password = $data['password'];
        
        $users = $this->getDoctrine()
        ->getRepository(User::class)
        ->findBy([
            'username' => $username
        ]);
        if($users != null){
            foreach ($users as $key => $us){
                    $us->setPassword($encoder->encodePassword($us,$password));
                    $em->persist($us);
                    $em->flush();              
            }
            
        }
        return new Response('Password %s successfully changed');
    }

    public function api()
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }
    // public function setdefaultoptions(optionsresolverinterface $resolver)     {         $resolver->setdefaults(array(             'data_class' => 'sf2\userbundle\entity\user',         ));     } 
}
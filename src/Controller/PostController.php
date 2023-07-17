<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post.")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        dump($posts);
        return $this->render('post/index.html.twig', [
            'posts'=>$posts
        ]);
    }


    /**
     * @Route("/create", name="create")
     * @param Request $request
     */
    public function create(Request $request): Response
    {
        //create a new post with title
        $post = new Post();
        $post->setTitle('This is going to be a title');

        // entity manager
        $em = $this->getDoctrine()->getManager();

        $em->persist($post);
        $em->flush();

        //return a response
        return $this->redirect($this->generateUrl('post.index'));
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param Post $post
     * @return Response
     */
    public function show(Post $post): Response
    {
        //create the show view
        return $this->render('post/show.html.twig', [
            'post'=>$post
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Post $post
     */
    public function remove(Post $post){
        $em = $this->getDoctrine()->getManager();

        $em->remove($post);
        $em->flush();

        $this->addFlash('success', message:'Post was removed');

        return $this->redirect($this->generateUrl('post.index'));
    }
}

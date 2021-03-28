<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Repository\CommunityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Security\LoginAuthenticator;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @Route("/{_locale}/event")
 * @IsGranted("ROLE_USER") 
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET","POST"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        $filtres = array('minPrice' => 0, 'maxPrice' => 0, 'date' => "");
        if(isset($_POST['minPrice']) && isset($_POST['maxPrice']) && isset($_POST['date']))
        {
            $filtres = array('minPrice' => $_POST['minPrice'], 'maxPrice' => $_POST['maxPrice'], 'date' => $_POST['date']);
        }
        
        return $this->render('event/index.html.twig', [
            'upcomingEvents' => $eventRepository->findUpcomingEvent($filtres),
            'upcomingEventsUser' => $eventRepository->findUpcomingEventUser($this->getUser(), $filtres),
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(CommunityRepository $commuRepo, Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && isset($_POST['community'])) {
            $event->addCommunity($commuRepo->findOneById($_POST['community']));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', [
            'community' => $commuRepo->findOneById($_GET['id_commu']),
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event, EventRepository $eventRepo): Response
    {
        $participe = true;
        if($eventRepo->isParticipating($this->getUser(), $event) == null){
            $participe = false;
        }
        return $this->render('event/show.html.twig', [
            'event' => $event,
            'participe' => $participe
        ]);
    }

    /**
     * @Route("/participe", name="event_participe", methods={"GET", "POST"})
     */
    public function participe(EventRepository $eventRepo): Response
    {
        if(isset($_POST['event']))
        {
            $event = $eventRepo->findOneById($_POST['event']);
            $event->addParticipant($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('event_index');
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(CommunityRepository $commuRepo, Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/edit.html.twig', [
            'community' => $commuRepo->findOneById($_GET['id_commu']),
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index');
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ContactsRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
class SearchByName extends AbstractController
{
    /**
     * @var ContactsRepository
     */
    protected $contactRepository;

    public function __construct(
        ContactsRepository $contactRepository
    ) {
        $this->contactRepository = $contactRepository;
    }


    public function __invoke(Request $request)
    {
        $keyword = $request->get('keyword');
        if (!$keyword) {
            throw new BadRequestHttpException('"keyword" is required');
        }

        $contacts = $this->contactRepository->findByName($request->get('keyword'));

        if (!$contacts) {
            throw $this->createNotFoundException(
                'No record found...'
            );
        }

        return $contacts;
    }
}

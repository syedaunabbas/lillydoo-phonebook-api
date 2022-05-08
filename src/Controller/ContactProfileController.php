<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use App\Entity\Contacts;
use App\Service\FileUploader;

#[AsController]
class ContactProfileController extends AbstractController
{
    /**
     * @var FileUploader
     */
    protected $fileUploader;

    public function __construct(
        FileUploader $fileUploader
    ) {
        $this->fileUploader = $fileUploader;
    }

    public function __invoke(Request $request): Contacts
    {
        // create a new entity and set its values
        $contact = new Contacts();
        $contact->setFirstname($request->get('firstname'));
        $contact->setLastname($request->get('lastname'));
        $contact->setCountry($request->get('country'));
        $contact->setCity($request->get('city'));
        $contact->setStreet($request->get('street'));
        $contact->setZipcode($request->get('zipcode'));
        $contact->setPhone($request->get('phone'));
        $contact->setBirthday($request->get('birthday'));
        $contact->setEmail($request->get('email'));

        $uploadedFile = $request->files->get('file');
        if ($uploadedFile) {
            // upload the file and save its filename
            $contact->profile = $this->fileUploader->upload($uploadedFile);
        }
        return $contact;
    }
}

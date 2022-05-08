<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\SearchByName;
use App\Controller\ContactProfileController;
use App\Repository\ContactsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ContactsRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('email')]
#[UniqueEntity('phone')]
#[ApiResource(
    attributes: [
        'route_prefix' => '/v1'
    ],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    collectionOperations: [
        'get',
        'post' => [
            'controller' => ContactProfileController::class,
            'deserialize' => false,
            'validation_groups' => ['Default', 'media_object_create'],
            'openapi_context' => [
                'requestBody' => [
                    'description' => 'Creates a Contacts resource.',
                    'required' => true,
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'firstname' => [
                                        'type' => 'string',
                                    ],
                                    'lastname' => [
                                        'type' => 'string',
                                    ],
                                    'country' => [
                                        'type' => 'string',
                                    ],
                                    'city' => [
                                        'type' => 'string',
                                    ],
                                    'street' => [
                                        'type' => 'string',
                                    ],
                                    'zipcode' => [
                                        'type' => 'string',
                                    ],
                                    'phone' => [
                                        'type' => 'string',
                                        'description' => 'xxx-xxxx-xxxx',
                                        'example' => '123-1234-5678'
                                    ],
                                    'birthday' => [
                                        'type' => 'string',
                                        'description' => 'YYYY-MM-DD'
                                    ],
                                    'email' => [
                                        'type' => 'string',
                                    ],
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                        'description' => 'Upload a profile image',
                                    ],
                                ]

                            ]
                        ]
                    ]
                ]
            ]
        ],
        'search_by_name' => [
            'method' => 'GET',
            'path' => '/search',
            'controller' => SearchByName::class,
            'read' => false,
            'openapi_context' => [
                'parameters' => [
                    [
                        'name' => 'keyword',
                        'in' => 'query',
                        'description' => 'The name of your contact',
                        'type' => 'string',
                        'required' => true,
                        'example' => 'Aun Abbas',
                    ]
                ]
            ]
        ]
    ],
    itemOperations: [
        'get', 'put', 'delete'
    ]
)]
class Contacts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["read"])]
    private $id;

    #[ORM\Column(type: 'string', nullable: false, name: 'first_name')]
    #[Groups(["read", "write"])]
    #[Assert\NotBlank()]
    protected $firstname;

    #[ORM\Column(type: 'string', nullable: false, name: 'last_name')]
    #[Groups(["read", "write"])]
    #[Assert\NotBlank()]
    protected $lastname;

    #[ORM\Column(type: 'string', length: 150, nullable: false, name: 'country')]
    #[Groups(["read", "write"])]
    #[Assert\NotBlank()]
    protected $country;

    #[ORM\Column(type: 'string', length: 150, nullable: false, name: 'city')]
    #[Groups(["read", "write"])]
    #[Assert\NotBlank()]
    protected $city;

    #[ORM\Column(type: 'string', length: 255, nullable: false, name: 'street')]
    #[Groups(["read", "write"])]
    #[Assert\NotBlank()]
    protected $street;

    #[ORM\Column(type: 'string', length: 20, nullable: false, name: 'zipcode')]
    #[Groups(["read", "write"])]
    #[Assert\NotBlank()]
    protected $zipcode;

    #[ORM\Column(type: 'string', length: 20, nullable: false, name: 'phone', unique: true)]
    #[Groups(["read", "write"])]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 8, max: 20, minMessage: 'min length', maxMessage: 'max length')]
    #[Assert\Regex(pattern:"/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", message:'This value is not valid, valid format is xxx-xxxx-xxxx')]
    protected $phone;

    #[ORM\Column(type: 'string', length: 20,  nullable: false, name: 'birthday')]
    #[Groups(["read", "write"])]
    #[Assert\NotBlank()]
    #[Assert\Date()]
    protected $birthday;

    #[ORM\Column(type: 'string', length: 150, nullable: false, name: 'email', unique: true)]
    #[Groups(["read", "write"])]
    #[Assert\NotBlank()]
    #[Assert\Email()]
    protected $email;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["read"])]
    protected ?\DateTime $created_at = null;


    #[ORM\Column(nullable: true)]
    #[Groups(["read", "write"])]
    #[ApiProperty(
        iri: 'http://schema.org/image',
        attributes: [
            'openapi_context' => [
                'type' => 'string'
            ]
        ]
    )]
    public ?string $profile = null;

    /******** METHODS ********/


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }


    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }


    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Prepersist gets triggered on Insert
     */
    #[ORM\PrePersist]
    public function updatedTimestamps()
    {
        if ($this->created_at == null) {
            $this->created_at = new \DateTime('now');
        }
    }
}

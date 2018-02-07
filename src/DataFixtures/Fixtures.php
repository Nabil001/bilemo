<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Feature;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductFeature;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Fixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var array
     */
    private $features = [];

    const PRODUCTS = [
        "Samsung Galaxy A8",
        "Honor 9",
        "Samsung Galaxy J5 2017",
        "Huawei P8 Lite 2017",
        "Alcatel POP 4-6",
        "Huawei Y6 Pro 2017",
        "Samsung Galaxy S7 Edge",
        "Huawei Mate 10 Pro",
        "Apple iPhone 8 Plus",
        "Samsung Galaxy Note 8",
        "Sony Xperia XA1",
        "Honor 7X",
    ];

    const DESCRIPTIONS = [
        "Un nouveau design, de meilleurs selfies et toujours plus de liberté…",
        "",
        "",
        "",
        "La phablette POP 4 (6) associe harmonieusement design et performances : un écran HD magnifique et un processeur puissant dans un fin boîtier métallique.",
        "",
        "Samsung présente les nouveaux Galaxy S7 au design élégant et raffiné né de l’alliance du verre et du métal. Sublimé par son écran aux bords incurvés, le Galaxy S7 edge se distingue par sa ligne unique. Galaxy S7. More than a phone.",
        "Le téléphone doté d'intelligence artificielle.",
        "L’iPhone 8 Plus inaugure une nouvelle génération d’iPhone. Paré du verre le plus résistant jamais conçu pour un smartphone et d’un contour plus solide en aluminium de qualité aérospatiale, il se charge sans fil et résiste à l’eau et à la poussière.",
        "Le Samsung Galaxy Note8 est conçu pour ceux qui agissent, ceux qui tentent, ceux qui créent. La précision de son S Pen offre des possibilités qui n’ont de limite que votre imagination.",
        "Un appareil photo sans égal dans un élégant design dont les contours semblent s'effacer.",
        "Design à écran sans bordure. Avec son taux d'occupation d'écran élevé et sa résolution FHD+ 2160 x 1080, l'écran FullView du Honor 7X offre une expérience visuelle aussi incroyable qu'immersive."
    ];

    const PRICES = [
      219.99,
      319.99,
      200.00,
      300.00,
      850.00,
      469.99,
      359.99,
      599.99,
      600.00,
      439.99,
      699.99,
      199.99,
    ];

    const PRODUCT_FEATURES = [
        "OS" => [
            "Android 7.1",
            "Android 7.0",
            "Android 7.0",
            "Android 7.0",
            "Android 6.0",
            "Android 7.1",
            "Android 6.0",
            "Android 8",
            "iOS 11",
            "Android 7.1",
            "Android 7.0",
            "Android 7.0",
        ],
        "Main Camera" => [
            "16MP",
            "20MP",
            "13MP",
            "12MP",
            "13MP",
            "13MP",
            "12MP",
            "20MP",
            "12MP",
            "12MP",
            "23MP",
            "16MP",
        ],
        "Item Dimensions" => [
            "149.2 x 70.6 x 8.4 mm",
            "147.3 x 70.9 x 7.45 mm",
            "146.3 x 71.3 x 7.8 mm",
            "147.2 x 73 x 7.63 mm",
            "160.9 x 81.5 x 7.95 mm",
            "143.9 x 71 x 8.05 mm",
            "150.9 x 72.6 x 7.7 mm",
            "154.2 x 74.5 x 7.9 mm",
            "158.4 x 78.1 x 7.5 mm",
            "162.5 x 74.6 x 8.5 mm",
            "145 x 67 x 8 mm",
            "156.5 x 75.3 x 7.6 mm",
        ],
        "Screen Size" => [
            "5.6",
            "5.1",
            "5.2",
            "5.2",
            "6",
            "5",
            "5.5",
            "6",
            "5.5",
            "6.3",
            "5",
            "5.9",
        ],
    ];

    const IMAGES = [
        [
            "http://mobile.free.fr/fiche_mobile/samsung/galaxy_A8/or/images/1.jpg",
            "http://mobile.free.fr/fiche_mobile/samsung/galaxy_A8/or/images/2.jpg",
            "http://mobile.free.fr/fiche_mobile/samsung/galaxy_A8/or/images/3.jpg",
        ],
        [
            "http://mobile.free.fr/fiche_mobile/honor/honor_9/bleu/images/1.jpg",
            "http://mobile.free.fr/fiche_mobile/honor/honor_9/bleu/images/2.jpg",
            "http://mobile.free.fr/fiche_mobile/honor/honor_9/bleu/images/3.jpg",
        ],
        [
            "http://mobile.free.fr/fiche_mobile/samsung/galaxy_J5/or/images/1.jpg",
            "http://mobile.free.fr/fiche_mobile/samsung/galaxy_J5/or/images/2.jpg",
            "http://mobile.free.fr/fiche_mobile/samsung/galaxy_J5/or/images/3.jpg",
        ],
        [
            "http://mobile.free.fr/fiche_mobile/huawei/P_8_Lite_2017/or/images/1.jpg",
            "http://mobile.free.fr/fiche_mobile/huawei/P_8_Lite_2017/or/images/2.jpg",
            "http://mobile.free.fr/fiche_mobile/huawei/P_8_Lite_2017/or/images/3.jpg",
        ],
        [
            "http://mobile.free.fr/fiche_mobile/alcatel/Pop_4-6/OrBlanc/images/1.jpg",
            "http://mobile.free.fr/fiche_mobile/alcatel/Pop_4-6/OrBlanc/images/2.jpg",
        ],
        [
            "http://mobile.free.fr/fiche_mobile/huawei/Y6_2017_Pro/noir/images/1.jpg",
            "http://mobile.free.fr/fiche_mobile/huawei/Y6_2017_Pro/noir/images/2.jpg",
        ],
        [
            "http://mobile.free.fr/fiche_mobile/samsung/galaxy_S7_Edge/or/images/1.jpg",
            "http://mobile.free.fr/fiche_mobile/samsung/galaxy_S7_Edge/or/images/2.jpg",
            "http://mobile.free.fr/fiche_mobile/samsung/galaxy_S7_Edge/or/images/3.jpg",
        ],
        [
            "http://mobile.free.fr/fiche_mobile/huawei/Mate_10_Pro/noir/images/1.jpg",
            "http://mobile.free.fr/fiche_mobile/huawei/Mate_10_Pro/noir/images/2.jpg",
            "http://mobile.free.fr/fiche_mobile/huawei/Mate_10_Pro/noir/images/3.jpg",
        ],
        [
            "http://mobile.free.fr/fiche_mobile/apple/iPhone_8_Plus/grisSideral/64go/images/1.jpg",
            "http://mobile.free.fr/fiche_mobile/apple/iPhone_8_Plus/grisSideral/64go/images/2.jpg",
            "http://mobile.free.fr/fiche_mobile/apple/iPhone_8_Plus/grisSideral/64go/images/3.jpg",
        ],
        [
            "http://mobile.free.fr/fiche_mobile/samsung/galaxy_note8/noir/images/1.jpg",
            "http://mobile.free.fr/fiche_mobile/samsung/galaxy_note8/noir/images/2.jpg",
            "http://mobile.free.fr/fiche_mobile/samsung/galaxy_note8/noir/images/3.jpg",
        ],
        [
            "http://mobile.free.fr/fiche_mobile/sony/xperia_XA1/noir/images/1.jpg",
            "http://mobile.free.fr/fiche_mobile/sony/xperia_XA1/noir/images/2.jpg",
            "http://mobile.free.fr/fiche_mobile/sony/xperia_XA1/noir/images/3.jpg",
        ],
        [
            "http://mobile.free.fr/fiche_mobile/honor/honor_7X/noir/images/1.jpg",
            "http://mobile.free.fr/fiche_mobile/honor/honor_7X/noir/images/2.jpg",
            "http://mobile.free.fr/fiche_mobile/honor/honor_7X/noir/images/3.jpg",
        ],
    ];

    const USERS = [
        'openclassrooms' => [
            [
                'Nabil',
                'Lemenuel',
                '1995-04-06'
            ],
            [
                'Pierre',
                'Dupont',
                '1994-01-16'
            ],
            [
                'John',
                'Doe',
                '1980-12-27'
            ],
            [
                'Blaise',
                'Pascal',
                '1986-04-06'
            ],
            [
                'Damien',
                'Delarocque',
                '1995-09-06'
            ],
            [
                'Bastien',
                'Lesaulnier',
                '1998-01-16'
            ],
            [
                'Clément',
                'Eustache',
                '1980-12-27'
            ],
            [
                'Kévin',
                'Valognes',
                '1986-04-06'
            ],
            [
                'Hugues',
                'Lemenuel',
                '1995-04-06'
            ],
            [
                'Jean',
                'Dupont',
                '1994-01-16'
            ],
            [
                'Sacha',
                'Fosse',
                '1980-12-27'
            ],
            [
                'Léo',
                'Manche',
                '1986-04-06'
            ],
            [
                'Jean',
                'Lafleur',
                '1994-01-16'
            ],
            [
                'Pierre',
                'Fosse',
                '1980-12-27'
            ],
            [
                'Hercule',
                'Manche',
                '1986-04-06'
            ]
        ],
        'sensiolabs' => [
            [
                'Seth',
                'Meyers',
                '1981-06-03'
            ],
            [
                'Stephen',
                'Colbert',
                '1975-04-01'
            ]
        ]
    ];

    const CLIENTS = [
        [
            'OpenClassrooms',
            'openclassrooms',
            'opc'
        ],
        [
            'SensioLabs',
            'sensiolabs',
            'fabpot'
        ]
    ];

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::PRODUCT_FEATURES as $featureName => $value) {
            $feature = new Feature();
            $feature->setName($featureName);
            $this->features[$featureName] = $feature;

            $manager->persist($feature);
        }
        $manager->flush();

        for ($i = 0 ; $i < count(self::PRODUCTS) ; $i++) {
            $product = new Product();
            $product->setName(self::PRODUCTS[$i])
                    ->setDescription(self::DESCRIPTIONS[$i])
                    ->setPrice(self::PRICES[$i])
                    ->setTaxeRate(20.00);

            foreach (self::IMAGES[$i] as $imageUrl) {
                $image = new Image();
                $image->setUrl($imageUrl);

                $product->addImage($image);
            }

            foreach (self::PRODUCT_FEATURES as $feature => $values) {
                $productFeature = new ProductFeature();
                $productFeature->setFeature($this->features[$feature]);
                $productFeature->setValue($values[$i]);

                $product->addProductFeature($productFeature);
            }

            $manager->persist($product);
        }

        foreach (self::CLIENTS as $clientData) {
            $client = new Client();
            $client->setCompany($clientData[0]);
            $client->setUsername($clientData[1]);
            $password = $this->encoder->encodePassword($client, $clientData[2]);
            $client->setPassword($password);

            if (isset(self::USERS[$clientData[1]])) {
                foreach (self::USERS[$clientData[1]] as $userData) {
                    $user = new User();
                    $user->setFirstname($userData[0]);
                    $user->setLastname($userData[1]);
                    $user->setBirthDate(new \DateTime($userData[2]));
                    $client->addUser($user);
                }
            }

            $manager->persist($client);
        }

        $manager->flush();
    }
}
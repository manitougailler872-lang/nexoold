<?php

namespace App\DataFixtures;

use App\Entity\Banque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BanqueFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $banques =   [
                [
                    'label' => 'BNP Paribas',
                    'countryIso' => 'FR',
                    'codeBanque' => '30004',
                    'codeSwift' => 'BNPAFRPP',
                    'logo' => 'bnp-paribas.png',
                    'active' => true,
                ],
                [
                    'label' => 'Société Générale',
                    'countryIso' => 'FR',
                    'codeBanque' => '30003',
                    'codeSwift' => 'SOGEFRPP',
                    'logo' => 'societe-generale.svg',
                    'active' => true,
                ],
                [
                    'label' => 'Crédit Agricole',
                    'countryIso' => 'FR',
                    'codeBanque' => '30006',
                    'codeSwift' => 'AGRIFRPP',
                    'logo' => 'credit-agricole.png',
                    'active' => true,
                ],
                [
                    'label' => 'Crédit Agricole CIB',
                    'countryIso' => 'FR',
                    'codeBanque' => '31489',
                    'codeSwift' => 'BSUIFRPP',
                    'logo' => 'credit-agricole-cib.png',
                    'active' => true,
                ],
                [
                    'label' => 'Crédit Mutuel',
                    'countryIso' => 'FR',
                    'codeBanque' => '10278',
                    'codeSwift' => 'CMCIFR2A',
                    'logo' => 'credit-mutuel.jpg',
                    'active' => true,
                ],
                [
                    'label' => 'CIC',
                    'countryIso' => 'FR',
                    'codeBanque' => '30066',
                    'codeSwift' => 'CMCIFRPP',
                    'logo' => 'cic.svg',
                    'active' => true,
                ],
                [
                    'label' => 'La Banque Postale',
                    'countryIso' => 'FR',
                    'codeBanque' => '20041',
                    'codeSwift' => 'PSSTFRPPPAR',
                    'logo' => 'banque-postale.png',
                    'active' => true,
                ],
                [
                    'label' => 'BPCE',
                    'countryIso' => 'FR',
                    'codeBanque' => '10000',
                    'codeSwift' => 'BPCEFRPP',
                    'logo' => 'bpce.png',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Populaire',
                    'countryIso' => 'FR',
                    'codeBanque' => '10007',
                    'codeSwift' => 'CCBPFRPP',
                    'logo' => 'banque-populaire.png',
                    'active' => true,
                ],
                [
                    'label' => 'Caisse d\'Épargne',
                    'countryIso' => 'FR',
                    'codeBanque' => '18315',
                    'codeSwift' => 'CEPAFRPP',
                    'logo' => 'caise-depargne.png',
                    'active' => true,
                ],
                [
                    'label' => 'Boursobank',
                    'countryIso' => 'FR',
                    'codeBanque' => '40618',
                    'codeSwift' => 'BOUSFRPPXXX',
                    'logo' => 'bourso-banq.png',
                    'active' => true,
                ],
                [
                    'label' => 'Hello bank!',
                    'countryIso' => 'FR',
                    'codeBanque' => '30004',
                    'codeSwift' => 'BNPAFRPP',
                    'logo' => 'hello-banq.png',
                    'active' => true,
                ],
                [
                    'label' => 'Fortuneo',
                    'countryIso' => 'FR',
                    'codeBanque' => '14518',
                    'codeSwift' => 'FTNOFRP1XXX',
                    'logo' => 'fortuneo.png',
                    'active' => true,
                ],
                [
                    'label' => 'Monabanq',
                    'countryIso' => 'FR',
                    'codeBanque' => '14690',
                    'codeSwift' => 'CMCIFR2A',
                    'logo' => 'mona-banq.png',
                    'active' => true,
                ],
                [
                    'label' => 'BforBank',
                    'countryIso' => 'FR',
                    'codeBanque' => '16218',
                    'codeSwift' => 'BFBKFRP1XXX',
                    'logo' => 'bfor-banq.webp',
                    'active' => true,
                ],
                [
                    'label' => 'LCL',
                    'countryIso' => 'FR',
                    'codeBanque' => '30002',
                    'codeSwift' => 'CRLYFRPP',
                    'logo' => 'lcl.svg',
                    'active' => true,
                ],
                [
                    'label' => 'HSBC Continental Europe',
                    'countryIso' => 'FR',
                    'codeBanque' => '30056',
                    'codeSwift' => 'CCFRFRPP',
                    'logo' => 'hsbc.png',
                    'active' => true,
                ],
                [
                    'label' => 'CCF',
                    'countryIso' => 'FR',
                    'codeBanque' => '30056',
                    'codeSwift' => 'CCFRFRPP',
                    'logo' => 'ccf-banque.png',
                    'active' => true,
                ],
                [
                    'label' => 'Crédit Coopératif',
                    'countryIso' => 'FR',
                    'codeBanque' => '42559',
                    'codeSwift' => 'CCOPFRPPXXX',
                    'logo' => 'credit-cooperatif.png',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Palatine',
                    'countryIso' => 'FR',
                    'codeBanque' => '40978',
                    'codeSwift' => 'BSPFFRPPXXX',
                    'logo' => 'banque-palatine.png',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Wormser Frères',
                    'countryIso' => 'FR',
                    'codeBanque' => '10268',
                    'codeSwift' => 'WORIFRPPXXX',
                    'logo' => 'banque-wormser-frres.jpg',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Delubac & Cie',
                    'countryIso' => 'FR',
                    'codeBanque' => '12879',
                    'codeSwift' => 'DELUFR22XXX',
                    'logo' => 'delubac-banque.jpg',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Transatlantique',
                    'countryIso' => 'FR',
                    'codeBanque' => '30568',
                    'codeSwift' => 'CMCIFRPP',
                    'logo' => 'banque-transatlantique.jpg',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Richelieu France',
                    'countryIso' => 'FR',
                    'codeBanque' => '14318',
                    'codeSwift' => 'RICEFRPPXXX',
                    'logo' => 'banque-richelieu.png',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Hottinguer',
                    'countryIso' => 'FR',
                    'codeBanque' => '11468',
                    'codeSwift' => 'HOTTFRPPXXX',
                    'logo' => 'banque-hottinguer.png',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Neuflize OBC',
                    'countryIso' => 'FR',
                    'codeBanque' => '30788',
                    'codeSwift' => 'NSMBFRPPXXX',
                    'logo' => 'banque-neuflize.png',
                    'active' => true,
                ],
                [
                    'label' => 'Oddo BHF',
                    'countryIso' => 'FR',
                    'codeBanque' => '14707',
                    'codeSwift' => 'ODDOFRPPXXX',
                    'logo' => 'oddo-bhf.svg',
                    'active' => true,
                ],
                [
                    'label' => 'Rothschild Martin Maurel',
                    'countryIso' => 'FR',
                    'codeBanque' => '12240',
                    'codeSwift' => 'MMMAFR2AXXX',
                    'logo' => 'rothschild_martin_maurel.png',
                    'active' => true,
                ],
                [
                    'label' => 'Rothschild & Co Bank',
                    'countryIso' => 'FR',
                    'codeBanque' => '12240',
                    'codeSwift' => 'ROTHFRPPXXX',
                    'logo' => 'rothschildco.png',
                    'active' => true,
                ],
                [
                    'label' => 'Banque de Savoie',
                    'countryIso' => 'FR',
                    'codeBanque' => '10548',
                    'codeSwift' => 'BSAVFR2CXXX',
                    'logo' => 'de-savoie.png',
                    'active' => true,
                ],
                [
                    'label' => 'Crédit Maritime',
                    'countryIso' => 'FR',
                    'codeBanque' => '11989',
                    'codeSwift' => 'CCBPFRPP',
                    'logo' => 'credit-maritime.png',
                    'active' => true,
                ],
                [
                    'label' => 'Crédit Municipal de Paris',
                    'countryIso' => 'FR',
                    'codeBanque' => '12589',
                    'codeSwift' => 'CMPAFR2PXXX',
                    'logo' => 'credit-municipal-paris.jpg',
                    'active' => true,
                ],
                [
                    'label' => 'Crédit Municipal de Bordeaux',
                    'countryIso' => 'FR',
                    'codeBanque' => '12598',
                    'codeSwift' => 'CMBRFR2BXXX',
                    'logo' => 'credit-municipal-bordeau.png',
                    'active' => true,
                ],
                [
                    'label' => 'Crédit Municipal de Lyon',
                    'countryIso' => 'FR',
                    'codeBanque' => '12599',
                    'codeSwift' => 'CMLYFR2LXXX',
                    'logo' => 'credit-municipal-lyon.jpg',
                    'active' => true,
                ],
                [
                    'label' => 'Crédit Municipal de Nantes',
                    'countryIso' => 'FR',
                    'codeBanque' => '12558',
                    'codeSwift' => 'CMNAFR2NXXX',
                    'logo' => 'credit-municipal-nantes.jpg',
                    'active' => true,
                ],
                [
                    'label' => 'Crédit Municipal de Toulouse',
                    'countryIso' => 'FR',
                    'codeBanque' => '12568',
                    'codeSwift' => 'CMTLFR2TXXX',
                    'logo' => 'credit-municipal-bordeau.png',
                    'active' => true,
                ],
                [
                    'label' => 'Crédit Foncier de France',
                    'countryIso' => 'FR',
                    'codeBanque' => '30030',
                    'codeSwift' => 'CFFRFRPPXXX',
                    'logo' => 'credit-foncier.jpg',
                    'active' => true,
                ],
                [
                    'label' => 'AXA Banque',
                    'countryIso' => 'FR',
                    'codeBanque' => '12548',
                    'codeSwift' => 'AXABFRPPXXX',
                    'logo' => 'axa-banque.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Ma French Bank',
                    'countryIso' => 'FR',
                    'codeBanque' => '16908',
                    'codeSwift' => 'LBDIFRPPXXX',
                    'logo' => 'ma-french-banq.jpg',
                    'active' => true,
                ],
                [
                    'label' => 'Nickel',
                    'countryIso' => 'FR',
                    'codeBanque' => '16598',
                    'codeSwift' => 'FPELFR21XXX',
                    'logo' => 'nickel.svg',
                    'active' => true,
                ],
                [
                    'label' => 'Qonto',
                    'countryIso' => 'FR',
                    'codeBanque' => '16958',
                    'codeSwift' => 'QNTOFRP1XXX',
                    'logo' => 'qonto.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Revolut Bank France',
                    'countryIso' => 'FR',
                    'codeBanque' => '',
                    'codeSwift' => 'REVOLT21XXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'N26 Bank France',
                    'countryIso' => 'FR',
                    'codeBanque' => '',
                    'codeSwift' => 'NTSBDEB1XXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Wise Europe France',
                    'countryIso' => 'FR',
                    'codeBanque' => '',
                    'codeSwift' => 'TRWIBEB1XXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'ING France',
                    'countryIso' => 'FR',
                    'codeBanque' => '',
                    'codeSwift' => 'INGBFRPPXXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Natixis',
                    'countryIso' => 'FR',
                    'codeBanque' => '30007',
                    'codeSwift' => 'NATXFRPPXXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'CACEIS Bank',
                    'countryIso' => 'FR',
                    'codeBanque' => '30001',
                    'codeSwift' => 'ISAEFRPPXXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Société de Financement Local',
                    'countryIso' => 'FR',
                    'codeBanque' => '16538',
                    'codeSwift' => 'SFILFRPPXXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'BPIFrance',
                    'countryIso' => 'FR',
                    'codeBanque' => '16188',
                    'codeSwift' => 'BDPMFRPPXXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Européenne du Crédit Mutuel',
                    'countryIso' => 'FR',
                    'codeBanque' => '10278',
                    'codeSwift' => 'BECMFRPPXXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Arkéa Banque Entreprises et Institutionnels',
                    'countryIso' => 'FR',
                    'codeBanque' => '15589',
                    'codeSwift' => 'CMBRFR2BARK',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Crédit Mutuel Arkéa',
                    'countryIso' => 'FR',
                    'codeBanque' => '15589',
                    'codeSwift' => 'CMBRFR2BXXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Courtois',
                    'countryIso' => 'FR',
                    'codeBanque' => '10268',
                    'codeSwift' => 'COURFR2TXXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Tarneaud',
                    'countryIso' => 'FR',
                    'codeBanque' => '12468',
                    'codeSwift' => 'TARNFR2LXXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Kolb',
                    'countryIso' => 'FR',
                    'codeBanque' => '12458',
                    'codeSwift' => 'KOLBFR21XXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Dupuy de Parseval',
                    'countryIso' => 'FR',
                    'codeBanque' => '10268',
                    'codeSwift' => 'DUPYFR2MXXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'BNP Paribas Personal Finance',
                    'countryIso' => 'FR',
                    'codeBanque' => '30004',
                    'codeSwift' => 'BNPAFRPP',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Floabank',
                    'countryIso' => 'FR',
                    'codeBanque' => '14989',
                    'codeSwift' => 'FLOAFRPPXXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Oney Bank',
                    'countryIso' => 'FR',
                    'codeBanque' => '14518',
                    'codeSwift' => 'ONEYFRPPXXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Carrefour Banque',
                    'countryIso' => 'FR',
                    'codeBanque' => '14906',
                    'codeSwift' => 'SOGEFRPP',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Stellantis France',
                    'countryIso' => 'FR',
                    'codeBanque' => '14940',
                    'codeSwift' => 'PSABFRPPXXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'RCI Banque',
                    'countryIso' => 'FR',
                    'codeBanque' => '30042',
                    'codeSwift' => 'RCINFRPPXXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'BRED Banque Populaire',
                    'countryIso' => 'FR',
                    'codeBanque' => '10107',
                    'codeSwift' => 'BREDFRPPXXX',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Populaire Rives de Paris',
                    'countryIso' => 'FR',
                    'codeBanque' => '10207',
                    'codeSwift' => 'CCBPFRPPMTG',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Populaire Auvergne Rhône Alpes',
                    'countryIso' => 'FR',
                    'codeBanque' => '16807',
                    'codeSwift' => 'CCBPFRPPGRE',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Populaire Bourgogne Franche-Comté',
                    'countryIso' => 'FR',
                    'codeBanque' => '10807',
                    'codeSwift' => 'CCBPFRPPDJO',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Populaire Grand Ouest',
                    'countryIso' => 'FR',
                    'codeBanque' => '13807',
                    'codeSwift' => 'CCBPFRPPNAN',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Populaire Méditerranée',
                    'countryIso' => 'FR',
                    'codeBanque' => '14607',
                    'codeSwift' => 'CCBPFRPPMAR',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Populaire Occitane',
                    'countryIso' => 'FR',
                    'codeBanque' => '17807',
                    'codeSwift' => 'CCBPFRPPTLS',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Populaire du Sud',
                    'countryIso' => 'FR',
                    'codeBanque' => '16607',
                    'codeSwift' => 'CCBPFRPPPPG',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Banque Populaire Val de France',
                    'countryIso' => 'FR',
                    'codeBanque' => '18707',
                    'codeSwift' => 'CCBPFRPPVER',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Caisse d\'Épargne Île-de-France',
                    'countryIso' => 'FR',
                    'codeBanque' => '17515',
                    'codeSwift' => 'CEPAFRPP751',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Caisse d\'Épargne Hauts de France',
                    'countryIso' => 'FR',
                    'codeBanque' => '16275',
                    'codeSwift' => 'CEPAFRPP627',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Caisse d\'Épargne Grand Est Europe',
                    'countryIso' => 'FR',
                    'codeBanque' => '15135',
                    'codeSwift' => 'CEPAFRPP513',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Caisse d\'Épargne Rhône Alpes',
                    'countryIso' => 'FR',
                    'codeBanque' => '13825',
                    'codeSwift' => 'CEPAFRPP382',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Caisse d\'Épargne Aquitaine Poitou-Charentes',
                    'countryIso' => 'FR',
                    'codeBanque' => '13335',
                    'codeSwift' => 'CEPAFRPP333',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Caisse d\'Épargne Bretagne Pays de Loire',
                    'countryIso' => 'FR',
                    'codeBanque' => '14445',
                    'codeSwift' => 'CEPAFRPP444',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Caisse d\'Épargne Côte d\'Azur',
                    'countryIso' => 'FR',
                    'codeBanque' => '18315',
                    'codeSwift' => 'CEPAFRPP831',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Caisse d\'Épargne Languedoc-Roussillon',
                    'countryIso' => 'FR',
                    'codeBanque' => '13485',
                    'codeSwift' => 'CEPAFRPP348',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Caisse d\'Épargne Loire-Centre',
                    'countryIso' => 'FR',
                    'codeBanque' => '14505',
                    'codeSwift' => 'CEPAFRPP450',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Caisse d\'Épargne Loire Drôme Ardèche',
                    'countryIso' => 'FR',
                    'codeBanque' => '14265',
                    'codeSwift' => 'CEPAFRPP426',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Caisse d\'Épargne Midi-Pyrénées',
                    'countryIso' => 'FR',
                    'codeBanque' => '13135',
                    'codeSwift' => 'CEPAFRPP313',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Caisse d\'Épargne Normandie',
                    'countryIso' => 'FR',
                    'codeBanque' => '11425',
                    'codeSwift' => 'CEPAFRPP142',
                    'logo' => 'default.webp',
                    'active' => true,
                ],
                [
                    'label' => 'Caisse d\'Épargne Provence-Alpes-Corse',
                    'countryIso' => 'FR',
                    'codeBanque' => '11315',
                    'codeSwift' => 'CEPAFRPP131',
                    'logo' => 'default.webp',
                    'active' => true,
                ],  
                [
                    'label' => 'UBS Switzerland AG',
                    'countryIso' => 'CH',
                    'codeBanque' => '00230',
                    'codeSwift' => 'UBSWCHZH80A',
                    'logo' => 'ubs.png',
                    'active' => true,
                ],
                [
                    'label' => 'Raiffeisen Suisse',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'raiffeisen.png',
                    'active' => true,
                ],

                [
                    'label' => 'PostFinance AG',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => 'POFICHBEXXX',
                    'logo' => 'postfinance.png',
                    'active' => true,
                ],

                [
                    'label' => 'Zürcher Kantonalbank',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => 'ZKBKCHZZ80A',
                    'logo' => 'zkb.png',
                    'active' => true,
                ],

                [
                    'label' => 'Banque Cantonale Vaudoise',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => 'BCVLCH2LXXX',
                    'logo' => 'bcv.png',
                    'active' => true,
                ],

                [
                    'label' => 'Banque Migros AG',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'migros-bank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Banque Cantonale de Genève',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => 'BCGECHGGXXX',
                    'logo' => 'bcge.png',
                    'active' => true,
                ],

                [
                    'label' => 'Berner Kantonalbank AG',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'bekb.png',
                    'active' => true,
                ],

                [
                    'label' => 'Luzerner Kantonalbank AG',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'lukb.png',
                    'active' => true,
                ],

                [
                    'label' => 'St.Galler Kantonalbank AG',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'sgkb.png',
                    'active' => true,
                ],

                [
                    'label' => 'Aargauische Kantonalbank',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'akb.png',
                    'active' => true,
                ],

                [
                    'label' => 'Basler Kantonalbank',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'bkb.png',
                    'active' => true,
                ],

                [
                    'label' => 'Basellandschaftliche Kantonalbank',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'blkb.png',
                    'active' => true,
                ],

                [
                    'label' => 'Thurgauer Kantonalbank',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'tkb.png',
                    'active' => true,
                ],

                [
                    'label' => 'Graubündner Kantonalbank',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'gkb.png',
                    'active' => true,
                ],

                [
                    'label' => 'Zuger Kantonalbank',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'zuger-kantonalbank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Schwyzer Kantonalbank',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'szkb.png',
                    'active' => true,
                ],

                [
                    'label' => 'Schaffhauser Kantonalbank',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'shkb.png',
                    'active' => true,
                ],

                [
                    'label' => 'Nidwaldner Kantonalbank',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'nkb.png',
                    'active' => true,
                ],

                [
                    'label' => 'Obwaldner Kantonalbank',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'okb.png',
                    'active' => true,
                ],

                [
                    'label' => 'Urner Kantonalbank',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'ukb.png',
                    'active' => true,
                ],

                [
                    'label' => 'Glarner Kantonalbank',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'glkb.png',
                    'active' => true,
                ],

                [
                    'label' => 'Banque Cantonale de Fribourg',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'bcf.png',
                    'active' => true,
                ],

                [
                    'label' => 'Banque Cantonale du Valais',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'bcvs.png',
                    'active' => true,
                ],

                [
                    'label' => 'Banque Cantonale Neuchâteloise',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'bcn.png',
                    'active' => true,
                ],

                [
                    'label' => 'Banque Cantonale du Jura',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'bcj.png',
                    'active' => true,
                ],

                [
                    'label' => 'Banca dello Stato del Cantone Ticino',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'bancastato.png',
                    'active' => true,
                ],

                [
                    'label' => 'Valiant Bank AG',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'valiant.png',
                    'active' => true,
                ],

                [
                    'label' => 'Bank Cler AG',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'bank-cler.png',
                    'active' => true,
                ],

                [
                    'label' => 'Swissquote Bank SA',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'swissquote.png',
                    'active' => true,
                ],

                [
                    'label' => 'Bank Julius Baer & Co. AG',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'julius-baer.png',
                    'active' => true,
                ],

                [
                    'label' => 'Bank Vontobel AG',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'vontobel.png',
                    'active' => true,
                ],

                [
                    'label' => 'Pictet & Cie',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'pictet.png',
                    'active' => true,
                ],

                [
                    'label' => 'Lombard Odier',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'lombard-odier.png',
                    'active' => true,
                ],

                [
                    'label' => 'J. Safra Sarasin',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'j-safra-sarasin.png',
                    'active' => true,
                ],

                [
                    'label' => 'Union Bancaire Privée (UBP)',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'ubp.png',
                    'active' => true,
                ],

                [
                    'label' => 'EFG Bank AG',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'efg.png',
                    'active' => true,
                ],

                [
                    'label' => 'Edmond de Rothschild (Suisse) SA',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'edmond-de-rothschild.png',
                    'active' => true,
                ],

                [
                    'label' => 'Mirabaud & Cie SA',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'mirabaud.png',
                    'active' => true,
                ],

                [
                    'label' => 'Banque Syz SA',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'syz.png',
                    'active' => true,
                ],

                [
                    'label' => 'Bank CIC (Schweiz) AG',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'cic.png',
                    'active' => true,
                ],

                [
                    'label' => 'WIR Bank Genossenschaft',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'wir-bank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Cembra Money Bank AG',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'cembra.png',
                    'active' => true,
                ],

                [
                    'label' => 'VZ Depotbank AG',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'vz-depotbank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Banque Bonhôte & Cie SA',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'bonhote.png',
                    'active' => true,
                ],

                [
                    'label' => 'Cornèr Banca SA',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'corner-banca.png',
                    'active' => true,
                ],

                [
                    'label' => 'Banque Heritage SA',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'banque-heritage.png',
                    'active' => true,
                ],

                [
                    'label' => 'Hyposwiss Private Bank Genève SA',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'hyposwiss.png',
                    'active' => true,
                ],

                [
                    'label' => 'LGT Bank (Schweiz) AG',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'lgt.png',
                    'active' => true,
                ],

                [
                    'label' => 'ONE swiss bank SA',
                    'countryIso' => 'CH',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'one-swiss-bank.png',
                    'active' => true,
                ],
                [
                    'label' => 'Sparkasse',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'sparkasse.png',
                    'active' => true,
                ],

                [
                    'label' => 'Volksbank Raiffeisenbank',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'volksbank-raiffeisenbank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Deutsche Bank AG',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => 'DEUTDEFFXXX',
                    'logo' => 'deutsche-bank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Postbank',
                    'countryIso' => 'DE',
                    'codeBanque' => '10010010',
                    'codeSwift' => 'PBNKDEFFXXX',
                    'logo' => 'postbank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Commerzbank AG',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => 'COBADEFFXXX',
                    'logo' => 'commerzbank.png',
                    'active' => true,
                ],

                [
                    'label' => 'ING Deutschland',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => 'INGDDEFFXXX',
                    'logo' => 'ing.png',
                    'active' => true,
                ],

                [
                    'label' => 'DKB - Deutsche Kreditbank AG',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => 'BYLADEM1001',
                    'logo' => 'dkb.png',
                    'active' => true,
                ],

                [
                    'label' => 'Comdirect',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => 'COBADEHDXXX',
                    'logo' => 'comdirect.png',
                    'active' => true,
                ],

                [
                    'label' => 'N26 Bank SE',
                    'countryIso' => 'DE',
                    'codeBanque' => '10011001',
                    'codeSwift' => 'NTSBDEB1XXX',
                    'logo' => 'n26.png',
                    'active' => true,
                ],

                [
                    'label' => 'TARGOBANK AG',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => 'CMCIDEDDXXX',
                    'logo' => 'targobank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Santander Consumer Bank AG',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => 'SCFBDE33XXX',
                    'logo' => 'santander.png',
                    'active' => true,
                ],

                [
                    'label' => 'HypoVereinsbank - UniCredit Bank GmbH',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => 'HYVEDEMMXXX',
                    'logo' => 'hypovereinsbank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Sparda-Bank',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'sparda-bank.png',
                    'active' => true,
                ],

                [
                    'label' => 'norisbank GmbH',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => 'NORSDE51XXX',
                    'logo' => 'norisbank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Consorsbank',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => 'CSDBDE71XXX',
                    'logo' => 'consorsbank.png',
                    'active' => true,
                ],

                [
                    'label' => 'BBBank eG',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => 'GENODE61BBB',
                    'logo' => 'bbbank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Revolut Bank UAB - Zweigniederlassung Deutschland',
                    'countryIso' => 'DE',
                    'codeBanque' => '10010178',
                    'codeSwift' => 'REVODEB2XXX',
                    'logo' => 'revolut.png',
                    'active' => true,
                ],

                [
                    'label' => 'Trade Republic Bank GmbH',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'trade-republic.png',
                    'active' => true,
                ],

                [
                    'label' => 'Oldenburgische Landesbank AG',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => 'OLBODEH2XXX',
                    'logo' => 'olb.png',
                    'active' => true,
                ],

                [
                    'label' => 'PSD Bank',
                    'countryIso' => 'DE',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'psd-bank.png',
                    'active' => true,
                ],
                 [
                    'label' => 'BNP Paribas Fortis',
                    'countryIso' => 'BE',
                    'codeBanque' => null,
                    'codeSwift' => 'GEBABEBB',
                    'logo' => 'bnp-paribas-fortis.png',
                    'active' => true,
                ],

                [
                    'label' => 'KBC Bank',
                    'countryIso' => 'BE',
                    'codeBanque' => null,
                    'codeSwift' => 'KREDBEBB',
                    'logo' => 'kbc.png',
                    'active' => true,
                ],

                [
                    'label' => 'ING Belgique',
                    'countryIso' => 'BE',
                    'codeBanque' => null,
                    'codeSwift' => 'BBRUBEBB',
                    'logo' => 'ing.png',
                    'active' => true,
                ],

                [
                    'label' => 'Belfius Banque',
                    'countryIso' => 'BE',
                    'codeBanque' => null,
                    'codeSwift' => 'GKCCBEBB',
                    'logo' => 'belfius.png',
                    'active' => true,
                ],

                [
                    'label' => 'Argenta Banque d’Épargne',
                    'countryIso' => 'BE',
                    'codeBanque' => null,
                    'codeSwift' => 'ARSPBE22',
                    'logo' => 'argenta.png',
                    'active' => true,
                ],

                [
                    'label' => 'Crelan',
                    'countryIso' => 'BE',
                    'codeBanque' => null,
                    'codeSwift' => 'NICABEBB',
                    'logo' => 'crelan.png',
                    'active' => true,
                ],

                [
                    'label' => 'Beobank',
                    'countryIso' => 'BE',
                    'codeBanque' => null,
                    'codeSwift' => 'CTBKBEBX',
                    'logo' => 'beobank.png',
                    'active' => true,
                ],

                [
                    'label' => 'CBC Banque',
                    'countryIso' => 'BE',
                    'codeBanque' => null,
                    'codeSwift' => 'CREGBEBB',
                    'logo' => 'cbc.png',
                    'active' => true,
                ],

                [
                    'label' => 'Europabank',
                    'countryIso' => 'BE',
                    'codeBanque' => null,
                    'codeSwift' => 'EURBBE99',
                    'logo' => 'europabank.png',
                    'active' => true,
                ],

                [
                    'label' => 'MeDirect Bank',
                    'countryIso' => 'BE',
                    'codeBanque' => null,
                    'codeSwift' => 'MBWMBEBB',
                    'logo' => 'medirect.png',
                    'active' => true,
                ],
                [
                    'label' => 'Royal Bank of Canada (RBC)',
                    'countryIso' => 'CA',
                    'codeBanque' => '003',
                    'codeSwift' => 'ROYCCAT2',
                    'logo' => 'rbc.png',
                    'active' => true,
                ],

                [
                    'label' => 'Toronto-Dominion Bank (TD)',
                    'countryIso' => 'CA',
                    'codeBanque' => '004',
                    'codeSwift' => 'TDOMCATTTOR',
                    'logo' => 'td.png',
                    'active' => true,
                ],

                [
                    'label' => 'Bank of Montreal (BMO)',
                    'countryIso' => 'CA',
                    'codeBanque' => '001',
                    'codeSwift' => 'BOFMCAM2',
                    'logo' => 'bmo.png',
                    'active' => true,
                ],

                [
                    'label' => 'Scotiabank',
                    'countryIso' => 'CA',
                    'codeBanque' => '002',
                    'codeSwift' => 'NOSCCATT',
                    'logo' => 'scotiabank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Canadian Imperial Bank of Commerce (CIBC)',
                    'countryIso' => 'CA',
                    'codeBanque' => '010',
                    'codeSwift' => 'CIBCCATT',
                    'logo' => 'cibc.png',
                    'active' => true,
                ],

                [
                    'label' => 'National Bank of Canada',
                    'countryIso' => 'CA',
                    'codeBanque' => '006',
                    'codeSwift' => 'BNDCCAMM',
                    'logo' => 'national-bank-canada.png',
                    'active' => true,
                ],

                [
                    'label' => 'Desjardins',
                    'countryIso' => 'CA',
                    'codeBanque' => '815',
                    'codeSwift' => 'CCDQCAMM',
                    'logo' => 'desjardins.png',
                    'active' => true,
                ],

                [
                    'label' => 'Tangerine Bank',
                    'countryIso' => 'CA',
                    'codeBanque' => '614',
                    'codeSwift' => 'INGDCATTTOR',
                    'logo' => 'tangerine.png',
                    'active' => true,
                ],

                [
                    'label' => 'EQ Bank / Equitable Bank',
                    'countryIso' => 'CA',
                    'codeBanque' => '623',
                    'codeSwift' => null,
                    'logo' => 'eq-bank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Simplii Financial',
                    'countryIso' => 'CA',
                    'codeBanque' => '010',
                    'codeSwift' => 'CIBCCATT',
                    'logo' => 'simplii-financial.png',
                    'active' => true,
                ],

                [
                    'label' => 'Laurentian Bank of Canada',
                    'countryIso' => 'CA',
                    'codeBanque' => '039',
                    'codeSwift' => 'BLCMCAMM',
                    'logo' => 'laurentian-bank.png',
                    'active' => true,
                ],

                [
                    'label' => 'ATB Financial',
                    'countryIso' => 'CA',
                    'codeBanque' => '219',
                    'codeSwift' => null,
                    'logo' => 'atb-financial.png',
                    'active' => true,
                ],

                [
                    'label' => 'Manulife Bank of Canada',
                    'countryIso' => 'CA',
                    'codeBanque' => '540',
                    'codeSwift' => null,
                    'logo' => 'manulife-bank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Vancity',
                    'countryIso' => 'CA',
                    'codeBanque' => '809',
                    'codeSwift' => null,
                    'logo' => 'vancity.png',
                    'active' => true,
                ],

                [
                    'label' => 'Meridian Credit Union',
                    'countryIso' => 'CA',
                    'codeBanque' => '837',
                    'codeSwift' => null,
                    'logo' => 'meridian.png',
                    'active' => true,
                ],

                [
                    'label' => 'Servus Credit Union',
                    'countryIso' => 'CA',
                    'codeBanque' => '899',
                    'codeSwift' => null,
                    'logo' => 'servus-credit-union.png',
                    'active' => true,
                ],

                [
                    'label' => 'Coast Capital Savings',
                    'countryIso' => 'CA',
                    'codeBanque' => '809',
                    'codeSwift' => null,
                    'logo' => 'coast-capital.png',
                    'active' => true,
                ],

                [
                    'label' => 'Citibank Canada',
                    'countryIso' => 'CA',
                    'codeBanque' => '260',
                    'codeSwift' => 'CITICATT',
                    'logo' => 'citibank.png',
                    'active' => true,
                ],

                [
                    'label' => 'JPMorgan Chase Bank Canada',
                    'countryIso' => 'CA',
                    'codeBanque' => '270',
                    'codeSwift' => null,
                    'logo' => 'jpmorgan-chase.png',
                    'active' => true,
                ],

                [
                    'label' => 'Bank of America Canada',
                    'countryIso' => 'CA',
                    'codeBanque' => '241',
                    'codeSwift' => null,
                    'logo' => 'bank-of-america.png',
                    'active' => true,
                ],
                 [
                    'label' => 'JPMorgan Chase Bank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'CHASUS33',
                    'logo' => 'chase.png',
                    'active' => true,
                ],

                [
                    'label' => 'Bank of America',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'BOFAUS3N',
                    'logo' => 'bank-of-america.png',
                    'active' => true,
                ],

                [
                    'label' => 'Wells Fargo Bank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'WFBIUS6S',
                    'logo' => 'wells-fargo.png',
                    'active' => true,
                ],

                [
                    'label' => 'Citibank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'CITIUS33',
                    'logo' => 'citibank.png',
                    'active' => true,
                ],

                [
                    'label' => 'U.S. Bank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'USBKUS44IMT',
                    'logo' => 'us-bank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Capital One',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'HIBKUS44',
                    'logo' => 'capital-one.png',
                    'active' => true,
                ],

                [
                    'label' => 'PNC Bank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'PNCCUS33',
                    'logo' => 'pnc-bank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Truist Bank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'BRBTUS33',
                    'logo' => 'truist.png',
                    'active' => true,
                ],

                [
                    'label' => 'TD Bank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'NRTHUS33',
                    'logo' => 'td-bank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Fifth Third Bank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'FTBCUS3C',
                    'logo' => 'fifth-third-bank.png',
                    'active' => true,
                ],

                [
                    'label' => 'Huntington National Bank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'HUNTUS33',
                    'logo' => 'huntington.png',
                    'active' => true,
                ],

                [
                    'label' => 'Citizens Bank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'CTZIUS33',
                    'logo' => 'citizens-bank.png',
                    'active' => true,
                ],

                [
                    'label' => 'M&T Bank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'MANTUS33',
                    'logo' => 'mt-bank.png',
                    'active' => true,
                ],

                [
                    'label' => 'KeyBank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'KEYBUS33',
                    'logo' => 'keybank.png',
                    'active' => true,
                ],

                [
                    'label' => 'BMO Bank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'HATRUS44',
                    'logo' => 'bmo.png',
                    'active' => true,
                ],

                [
                    'label' => 'Ally Bank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'ally-bank.png',
                    'active' => true,
                ],

                [
                    'label' => 'American Express National Bank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => null,
                    'logo' => 'american-express.png',
                    'active' => true,
                ],

                [
                    'label' => 'First Citizens Bank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'FCBTUS33',
                    'logo' => 'first-citizens-bank.png',
                    'active' => true,
                ],

                [
                    'label' => 'HSBC Bank USA',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'MRMDUS33',
                    'logo' => 'hsbc.png',
                    'active' => true,
                ],

                [
                    'label' => 'Regions Bank',
                    'countryIso' => 'US',
                    'codeBanque' => null,
                    'codeSwift' => 'UPNBUS44',
                    'logo' => 'regions-bank.png',
                    'active' => true,
                ],
            ];
   
        foreach($banques as $banque){

                $item = new Banque();
                
                $item->setLabel($banque['label'])
                ->setActive(true)
                ->setCountryIso($banque['countryIso'])
                ->setCodeSwift($banque['codeSwift'])
                ->setCodeBanque($banque['codeBanque'])
                ->setLogo($banque['logo']);

                $manager->persist($item);
        }
        $manager->flush();
    }
    
    public function getDependencies(): array
    {
        return [
           
        ];
    }
}
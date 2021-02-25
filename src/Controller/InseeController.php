<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/insee')]
class InseeController extends AbstractController
{
    public function __construct(private HttpClientInterface $client)
    {

    }

    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return new Response("");
    }

    #[Route('/siren', name:'siren')]
    public function returnInfos(Request $request) : Response
    {
        // il faut supprimer les espaces pour l'api de l'insee
        $siren = str_replace(' ', '', $request->query->get('siren'));
        $type = strlen($siren) == 9 ? 'siren' : 'siret';

        $response = $this->client->request(
            'GET',
            'https://api.insee.fr/entreprises/sirene/V3/'.$type.'/'.$siren,
            [
                'headers' => [
                    "Accept"=> "application/json"
                ],
                'auth_bearer' => '2ab7cc28-ed22-3f3f-a2fe-420b114ebf0e'
            ]
        );
        $content = $response->toArray();
        $reponse = [];

        if ($type =='siren') {
            $reponse['type'] = 'siren';
            $reponse['raisonSociale'] = $content['uniteLegale']['periodesUniteLegale'][0]['denominationUniteLegale'];
            $activite = $content['uniteLegale']['periodesUniteLegale'][0]['activitePrincipaleUniteLegale'];
        } else {
            $reponse['type'] = 'siret';
            $reponse['raisonSociale'] = $content['etablissement']['uniteLegale']['denominationUniteLegale'];

            $reponse['adresse'] = $content['etablissement']['adresseEtablissement']['numeroVoieEtablissement'] . ' ' .
                $content['etablissement']['adresseEtablissement']['typeVoieEtablissement'] . ' ' .
                $content['etablissement']['adresseEtablissement']['libelleVoieEtablissement'];

            $reponse['complementAdresse'] = $content['etablissement']['adresseEtablissement']['complementAdresseEtablissement'];
            $reponse['codePostal'] = $content['etablissement']['adresseEtablissement']['codePostalEtablissement'];
            $reponse['ville'] = $content['etablissement']['adresseEtablissement']['libelleCommuneEtablissement'];
            $activite = $content['etablissement']['uniteLegale']['activitePrincipaleUniteLegale'];
        }
        $reponse['activite'] = $this->returnInfosNaf($activite);
        return $this->json($reponse);
    }

    #[Route('/naf', name:'naf')]
    public function returnInfosNaf(string $naf) : String
    {
        $response = $this->client->request(
            'GET',
            'https://api.insee.fr/metadonnees/nomenclatures/v1/codes/nafr2/sousClasse/'.$naf,
            [
                'headers' => [
                    "Accept"=> "application/json"
                ],
                'auth_bearer' => '2ab7cc28-ed22-3f3f-a2fe-420b114ebf0e'
            ]
        );
        $content = $response->toArray();
        return $content['intitule'];
    }
}

<?php

namespace Espo\Modules\Autocrm\Controllers;

use Espo\Core\Api\Response;
use Espo\Core\Api\Request;
use Espo\Core\Record\ReadParams;
use Espo\Core\Record\ServiceContainer;
use Espo\Core\Select\SearchParams;
use Espo\Core\Utils\Json;
use Espo\Modules\Crm\Entities\Contact;
use Espo\Modules\Crm\Entities\Lead;

class Autocrm
{
    public function __construct(private ServiceContainer $sc) 
    {}

    public function getActionContacts(Request $request, Response $response): void
    {
        $id = $request->getRouteParam('id'); // GET parameter
        $leadService = $this->sc->get(Lead::ENTITY_TYPE);
        $contactService = $this->sc->get(Contact::ENTITY_TYPE);
        $lead = $leadService->read($id, ReadParams::create());
        $contacts = $contactService->find(SearchParams::fromRaw(['emailAddress' => $lead->get('emailAddress')]));
        
        $response->writeBody(
            Json::encode([
                'list' =>  $contacts->getValueMapList(),
                'total' => $contacts->getTotal()
            ])
        );
    }
}

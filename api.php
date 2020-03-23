<?php
    $result = array();
    // Get contents
    $html = file_get_contents( 'https://www.sportsinteraction.com/specials/us-elections-betting/' );
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    $XPath = new DOMXPath($doc);
    // Get data
    $data_component = $XPath->query('//*[@id="page-container"]//*[@data-component="Games"]');
    $data_component = $data_component->item(0);
    // Parse data_props
    $data_props = json_decode($data_component->getAttribute("data-props"), true);

    foreach($data_props['games'] as $data_prop_index => $data_prop){
        // Set Bet name
        $result[$data_prop_index]['BetName'] = $data_prop['gameName'];
        foreach($data_prop['betTypeGroups'][0]['betTypes'][0]['events'][0]['runners'] as $bet_index => $bet_option){
            // Set bet options
            $result[$data_prop_index]['BetOptions'][$bet_index]['Outcome'] = $bet_option['runner'];
            $result[$data_prop_index]['BetOptions'][$bet_index]['Odds'] = $bet_option['fractionPrice'];
        }
    }
   
   // Response JSON format
   header('Content-Type: application/json');
   echo json_encode($result);
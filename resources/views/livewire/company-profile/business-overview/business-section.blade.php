@php
    $businessContent = $menuLinks['business'] ?? "";
    $businessContent = preg_replace('/\s+/', ' ', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace('\n', '', $businessContent);
    $businessContent = str_replace(':#000000;', ':#121A0F;', $businessContent);
    $businessContent = str_replace('Item 1.', '', $businessContent);
    $businessContent = str_replace('\u{A0}\u{A0}\u{A0}\u{A0}', '', $businessContent);
    $businessContent = preg_replace('/[\x00-\x1F\x7F]/', '', $businessContent);
    $businessContent = str_replace('style="height:42.75pt;position:relative;width:100%"', '', $businessContent);
    $businessContent = str_replace('style="bottom:0;position:absolute;width:100%"', '', $businessContent);
    $businessContent = str_replace('style="min-height:42.75pt;width:100%"', '', $businessContent);
    $businessContent = str_replace('<br/>', '', $businessContent);
    $businessContent = preg_replace('/Apple Inc. \| \d{4} Form 10-K \| [0-9]+/i', '| Form-K |', $businessContent);
    $businessContent = str_replace('||', '', $businessContent);
    $businessContent = preg_replace('/(<img\s+[^>]*src=")([^"]+)("[^>]*>)/i', '${1}' . $imagesUrl . '/${2}${3}', $businessContent);
    $businessContent = preg_replace('/<hr(.?)\/>/i', '', $businessContent);
    $businessContent = preg_replace('/Item 1([a-z]?)./i', '', $businessContent);
    $businessContent = preg_replace('/<hr (.?)[a-z="-:]+\/>/mi', '', $businessContent);
    $businessContent = preg_replace('/class="(.?)+"/i', '', $businessContent);
    $businessContent = preg_replace('/<div/i', '<p', $businessContent);
    $businessContent = preg_replace('/<div(.?)(i?)(d?)=[a-z"0-9_-]+\/>/i', '<p>', $businessContent);
    $businessContent = preg_replace('/<\/div>/i', '</p>', $businessContent);
    $businessContent = preg_replace('/<p+ [a-z]+=("|\')[a-z0-9_-]+("|\')(.?)\/>/mi', '', $businessContent);
    $businessContent = preg_replace('/<p+ [a-z]+=("|\')[a-z0-9:;_-]+("|\')(.?)><[a-z]+(.?)[a-z=";:#0-9-\',%]+>((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)((&nbsp;)?)<\/[a-z]+><\/[a-z]>/mi', '', $businessContent);
    $businessContent = preg_replace('/business(?=\<) /i', "<p class='title'>Business</p>", $businessContent, 1);
    $businessContent = preg_replace('/business</i', "<p class='title'>Business</p><", $businessContent, 1);
    $businessContent = preg_replace('/<p+ [a-z]+=("|\')[a-z0-9:;_-]+("|\')(.?)><[a-z]+(.?)[a-z=";:#0-9-\',%>]+<p class=\'title\'>Business<\/p><\/[a-z]+><\/[a-z]+>/mi', "<p class='title'>Business</p>", $businessContent);
    $businessContent = preg_replace('/>company background</i', "><span class='anchor' id='business-information-company-background'></span><p class='subtitle'>Company Background</p><", $businessContent, 1);
    $businessContent = preg_replace('/>products</i', "><span class='anchor' id='business-information-products'></span><p class='subtitle'>Products</p><", $businessContent, 1);
    $businessContent = preg_replace('/>services</i', "><span class='anchor' id='business-information-services'></span><p class='subtitle'>Services</p><", $businessContent, 1);
    $businessContent = preg_replace('/>markets and distribution</i', "><span class='anchor' id='business-information-market-distribution'></span><p class='subtitle'>Markets and Distribution</p><", $businessContent, 1);
    $businessContent = preg_replace('/>competition</i', "><span class='anchor' id='business-information-competition'></span><p class='subtitle'>Competition</p><", $businessContent, 1);
    $businessContent = preg_replace('/>supply of components</i', "><span class='anchor' id='business-information-supply-of-components'></span><p class='subtitle'>Supply of Components</p><", $businessContent, 1);
    $businessContent = preg_replace('/>research and development</i', "><span class='anchor' id='business-information-rnd'></span><p class='subtitle'>Research and Development</p><", $businessContent, 1);
    $businessContent = preg_replace('/>intellectual property</i', "><span class='anchor' id='business-information-intellectual-property'></span><p class='subtitle'>Intellectual Property</p><", $businessContent, 1);
    $businessContent = preg_replace('/>business seasonality and product introductions</i', "><span class='anchor' id='business-information-business-seasonality'></span><p class='subtitle'>Business Seasonality and Product Introductions</p><", $businessContent, 1);
    $businessContent = preg_replace('/>human capital</i', "><span class='anchor' id='business-information-human-capital'></span><p class='subtitle'>Human Capital</p><", $businessContent, 1);
    $businessContent = preg_replace('/>available information</i', "><span class='anchor' id='business-information-available-information'></span><p class='subtitle'>Available Information</p><", $businessContent, 1);
    $businessContent = str_replace('9pt', '14px', $businessContent);
    $businessContent = str_replace('8.5pt', '14px', $businessContent);
    $sidebarLinks = [];
    if (preg_match('/>company background</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Company Background',
            'link' => '#business-information-company-background',
            'startRegex' => "<p class='subtitle'>Company Background<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-products'><\/span>",
        ];
    }
    if (preg_match('/>products</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Products',
            'link' => '#business-information-products',
            'startRegex' => "<p class='subtitle'>Products<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-services'><\/span>",
        ];
    }
    if (preg_match('/>services</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Services',
            'link' => '#business-information-services',
            'startRegex' => "<p class='subtitle'>Services<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-market-distribution'><\/span>",
        ];
    }
    if (preg_match('/>markets and distribution</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Markets and Distribution',
            'link' => '#business-information-market-distribution',
            'startRegex' => "<p class='subtitle'>Markets and Distribution<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-competition'><\/span>",
        ];
    }
    if (preg_match('/>competition</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Competition',
            'link' => '#business-information-competition',
            'startRegex' => "<p class='subtitle'>Markets and Distribution<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-supply-of-components'><\/span>",
        ];
    }
    if (preg_match('/>supply of components</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Supply of Components',
            'link' => '#business-information-supply-of-components',
            'startRegex' => "<p class='subtitle'>Supply of Components<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-rnd'><\/span>",
        ];
    }
    if (preg_match('/>research and development</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Research and Development',
            'link' => '#business-information-rnd',
            'startRegex' => "<p class='subtitle'>Research and Development<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-intellectual-property'><\/span>",
        ];
    }
    if (preg_match('/>intellectual property</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Intellectual Property',
            'link' => '#business-information-intellectual-property',
            'startRegex' => "<p class='subtitle'>Intellectual Property<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-business-seasonality'><\/span>",
        ];
    }
    if (preg_match('/>business seasonality and product introductions</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Business Seasonality and Product Introductions',
            'link' => '#business-information-business-seasonality',
            'startRegex' => "<p class='subtitle'>Business Seasonality and Product Introductions<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-human-capital'><\/span>",
        ];
    }
    if (preg_match('/>human capital</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Human Capital',
            'link' => '#business-information-human-capital',
            'startRegex' => "<p class='subtitle'>Human Capital<\/p>",
            'endRegex' => "<span class='anchor' id='business-information-available-information'><\/span>",
        ];
    }
    if (preg_match('/>available information</i', $businessContent)) {
        $sidebarLinks[] = [
            'anchorText' => 'Available Information',
            'link' => '#business-information-available-information',
            'startRegex' => "<p class='subtitle'>Available Information<\/p>",
            'endRegex' => '<p ><p ><\/p><\/p>',
        ];
    }
@endphp

@include('livewire.company-profile.business-overview.content')

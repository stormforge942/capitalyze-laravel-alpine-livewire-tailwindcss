<div class="border border-gray">
    <p class="border-b border-gray bg-gray-100 p-2"><b>Item 3 Form of Organization</b></p>
    <p class="border-b border-gray p-2">If you are filing an umbrella registration, the information in Item 3 should be provided for the filing adviser only.</p>
    <div class="p-2">
        <table>
            <tbody>
                <tr>
                    <td class="align-top">A.</td>
                    <td colspan="3">
                        <p>How are you organized?</p>
                        <?php
                            $organization_types = [
                                'Corporation', 'Sole Proprietorship', 'Limited Liability Partnership (LLP)', 'Partnership', 'Limited Liability Company (LLC)', 'Limited Partnership (LP)'
                            ];
                        ?>
                        @foreach ($organization_types as $organ)
                            <p><img src="{{ asset('img/adv_radio_' . (str_contains($organ, $adviser['form_data']['3A']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /> {{ $organ }}</p>
                        @endforeach
                        <p><img src="{{ asset('img/adv_radio_' . ($adviser['form_data']['3A-Other'] == 'None' ? 'un' : '') . 'checked.gif') }}" class="inline align-middle" /> Other (specify): 
                            <span class="font-bold text-[#f00]">{{ formatAdviserString($adviser['form_data']['3A-Other']) }}</span></p>
                        
                        <p>If you are changing your response to this Item, see Part 1A Instruction 4.</p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top">B.</td>
                    <td colspan="3">
                        <p>In what month does your fiscal year end each year?</p>
                        <p class="bold text-[#f00]">{{ formatAdviserString($adviser['form_data']['3B']) }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top">C.</td>
                    <td colspan="3">
                        <p>Under the laws of what state or country are you organized?</p>
                        <table>
                            <tbody>
                                <tr>
                                    <td>State</td>
                                    <td>Country</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['3C-State']) }}</span>
                                    </td>
                                    <td>
                                        <span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['3C-Country']) }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table> 
                        <p>If you are a partnership, provide the name of the state or country under whose laws your partnership was formed. If you are a sole proprietor, provide the name of the state or country where you reside.</p> 
                        <p>If you are changing your response to this Item, see Part 1A Instruction 4.</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
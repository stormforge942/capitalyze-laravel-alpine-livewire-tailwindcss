<div class="border border-gray">
    <p class="border-b border-gray bg-gray-100 p-2"><b>Item 7 Financial Industry Affiliations</b></p>
    <p class="border-b border-gray p-2">In this Item, we request information about your financial industry affiliations and activities. This information identifies areas in which conflicts of interest may occur between you and your clients.</p>
    <div class="p-2">
        <table>
            <tbody>
                <tr>
                    <td class="align-top">A.</td>
                    <td colspan="3">
                        <p>This part of Item 7 requires you to provide information about you and your related persons, including foreign affiliates. Your related persons are all of your advisory affiliates and any person that is under common control with you.</p>
                        <p>You have a related person that is a (check all that apply):</p>
                        <?php
                            $businesses = [
                                'broker-dealer, municipal securities dealer, or government securities broker or dealer (registered or unregistered)', 
                                'other investment adviser (including financial planners)',
                                'registered municipal advisor',
                                'registered security-based swap dealer',
                                'major security-based swap participant',
                                'commodity pool operator or commodity trading advisor (whether registered or exempt from registration)',
                                'futures commission merchant',
                                'banking or thrift institution',
                                'trust company',
                                'accountant or accounting firm',
                                'lawyer or law firm',
                                'insurance company or agency',
                                'pension consultant',
                                'real estate broker or dealer',
                                'sponsor or syndicator of limited partnerships (or equivalent), excluding pooled investment vehicles',
                                'sponsor, general partner, managing member (or equivalent) of pooled investment vehicles'
                            ];
                        ?>
                        <table>
                            <tbody>
                                @foreach ($businesses as $index => $business)
                                    <tr>
                                        <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['7A(' . ($index + 1) . ')']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                                        <td>({{ $index + 1 }})</td>
                                        <td>{{ $business }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <p>Note that Item 7.A. should not be used to disclose that some of your employees perform investment advisory functions or are registered representatives of a broker-dealer. The number of your firm's employees who perform investment advisory functions should be disclosed under Item 5.B.(1). The number of your firm's employees who are registered representatives of a broker-dealer should be disclosed under Item 5.B.(2).</p>
                        
                        <p>Note that if you are filing an umbrella registration, you should not check Item 7.A.(2) with respect to your relying advisers, and you do not have to complete Section 7.A. in Schedule D for your relying advisers. You should complete a Schedule R for each relying adviser.</p>
                        
                        <p>For each related person, including foreign affiliates that may not be registered or required to be registered in the United States, complete Section 7.A. of Schedule D.</p>
                        
                        <p>You do not need to complete Section 7.A. of Schedule D for any related person if: (1) you have no business dealings with the related person in connection with advisory services you provide to your clients; (2) you do not conduct shared operations with the related person; (3) you do not refer clients or business to the related person, and the related person does not refer prospective clients or business to you; (4) you do not share supervised persons or premises with the related person; and (5) you have no reason to believe that your relationship with the related person otherwise creates a conflict of interest with your clients.</p>
                        
                        <p>You must complete Section 7.A. of Schedule D for each related person acting as qualified custodian in connection with advisory services you provide to your clients (other than any mutual fund transfer agent pursuant to rule 206(4)-2(b)(1)), regardless of whether you have determined the related person to be operationally independent under rule 206(4)-2 of the Advisers Act.</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
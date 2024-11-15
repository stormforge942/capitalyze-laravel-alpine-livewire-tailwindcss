<div class="border border-gray">
    <p class="border-b border-gray bg-gray-100 p-2"><b>Item 6 Other Business Activities</b></p>
    <p class="border-b border-gray p-2">In this item, we request information about your firm's other business activites</p>
    <div class="p-2">
        <table>
            <tbody>
                <tr>
                    <td class="align-top">A.</td>
                    <td colspan="3">
                        <p>You are actively engaged in business as a (check all that apply):</p>
                        <?php
                            $businesses = [
                                'broker-dealer (registered or unregistered)', 
                                'registered representative of a broker-dealer',
                                'commodity pool operator or commodity trading advisor (whether registered or exempt from registration)',
                                'futures commission merchant',
                                'real estate broker, dealer, or agent',
                                'insurance broker or agent',
                                'bank (including a separately identifiable department or division of a bank)',
                                'trust company',
                                'registered municipal advisor',
                                'registered security-based swap dealer',
                                'major security-based swap participant',
                                'accountant or accounting firm',
                                'lawyer or law firm',
                            ];
                        ?>
                        <table>
                            <tbody>
                                @foreach ($businesses as $index => $business)
                                    <tr>
                                        <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['6A(' . ($index + 1) . ')']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                                        <td>({{ $index + 1 }})</td>
                                        <td>{{ $business }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td><img src="{{ asset('img/adv_multi_' . ($adviser['form_data']['6A(14)-Other'] == 'None' ? 'un' : '') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td>(14)</td>
                                    <td>other financial product salesperson (specify): {{ formatAdviserString($adviser['form_data']['6A(14)-Other']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <p>If you are changing your response to this Item, see Part 1A Instruction 4.</p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top">B.</td>
                    <td colspan="3">
                        <table>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td width="1%">Yes</td>
                                    <td width="1%">No</td>
                                </tr>
                                <tr>
                                    <td class="align-top">(1)</td>
                                    <td width="98%">Are you actively engaged in any other business not listed in Item 6.A. (other than giving investment advice)?	</td>
                                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['6B(1)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['6B(1)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                                </tr>
                                <tr>
                                    <td class="align-top">(2)</td>
                                    <td>
                                        <p>If yes, is this other business your primary business?</p>
                                        <p>If "yes," describe this other business on Section 6.B.(2) of Schedule D, and if you engage in this business under a different name, provide that name.</p>
                                    </td>
                                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['6B(2)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['6B(2)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td width="1%">Yes</td>
                                    <td width="1%">No</td>
                                </tr>
                                <tr>
                                    <td class="align-top">(3)</td>
                                    <td>
                                        <p>Do you sell products or provide services other than investment advice to your advisory clients?</p>
                                        
                                        <p>If "yes," describe this other business on Section 6.B.(3) of Schedule D, and if you engage in this business under a different name, provide that name.</p>
                                    </td>
                                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['6B(3)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['6B(3)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
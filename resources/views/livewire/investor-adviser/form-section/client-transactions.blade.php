<div class="border border-gray">
    <p class="border-b border-gray bg-gray-100 p-2"><b>Item 8 Participation or Interest in Client Transactions</b></p>
    <p class="border-b border-gray p-2">
        In this Item, we request information about your participation and interest in your clients' transactions. This information identifies additional areas in which conflicts of interest may occur between you and your clients. Newly-formed advisers should base responses to these questions on the types of participation and interest that you expect to engage in during the next year.
        Like Item 7, Item 8 requires you to provide information about you and your related persons, including foreign affiliates.
    </p>
    <div class="p-2">
        <table>
            <tbody>
                <tr>
                    <td colspan="4">
                        <p class="border-b border-gray bg-gray-100 p-2"><b>Proprietary Interest in Client Transactions</b></p>
                    </td>
                </tr>
                <tr>
                    <td>A.</td>
                    <td width="98%">Do you or any related person:</td>
                    <td class="text-center" width="1%"><b>Yes</b></td>
                    <td class="text-center" width="1%"><b>No</b></td>
                </tr>
                <tr>
                    <td class="align-top"></td>
                    <td width="98%">(1) buy securities for yourself from advisory clients, or sell securities you own to advisory clients (principal transactions)?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8A(1)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8A(1)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td class="align-top"></td>
                    <td width="98%">(2) buy or sell for yourself securities (other than shares of mutual funds) that you also recommend to advisory clients?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8A(2)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8A(2)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td class="align-top"></td>
                    <td width="98%">(3) recommend securities (or other investment products) to advisory clients in which you or any related person has some other proprietary (ownership) interest (other than those mentioned in Items 8.A.(1) or (2))?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8A(3)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8A(3)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <p class="border-b border-gray bg-gray-100 p-2"><b>Sales Interest in Client Transactions</b></p>
                    </td>
                </tr>
                <tr>
                    <td>B.</td>
                    <td width="98%">Do you or any related person:</td>
                    <td class="text-center" width="1%"><b>Yes</b></td>
                    <td class="text-center" width="1%"><b>No</b></td>
                </tr>
                <tr>
                    <td class="align-top"></td>
                    <td width="98%">(1) as a broker-dealer or registered representative of a broker-dealer, execute securities trades for brokerage customers in which advisory client securities are sold to or bought from the brokerage customer (agency cross transactions)?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8B(1)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8B(1)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td class="align-top"></td>
                    <td width="98%">(2) recommend to advisory clients, or act as a purchaser representative for advisory clients with respect to, the purchase of securities for which you or any related person serves as underwriter or general or managing partner?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8B(2)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8B(2)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td class="align-top"></td>
                    <td width="98%">(3) recommend purchase or sale of securities to advisory clients for which you or any related person has any other sales interest (other than the receipt of sales commissions as a broker or registered representative of a broker-dealer)?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8B(3)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8B(3)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>

                <tr>
                    <td colspan="4">
                        <p class="border-b border-gray bg-gray-100 p-2"><b>Investment or Brokerage Discretion</b></p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top">C.</td>
                    <td width="98%">Do you or any related person have discretionary authority to determine the:</td>
                    <td class="text-center" width="1%"><b>Yes</b></td>
                    <td class="text-center" width="1%"><b>No</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td width="98%">(1) securities to be bought or sold for a client's account?	</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8C(1)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8C(1)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td width="98%">(2) amount of securities to be bought or sold for a client's account?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8C(2)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8C(2)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td width="98%">(3) broker or dealer to be used for a purchase or sale of securities for a client's account?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8C(3)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8C(3)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td width="98%">(4) commission rates to be paid to a broker or dealer for a client's securities transactions?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8C(4)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8C(4)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td class="align-top">D.</td>
                    <td width="98%">If you answer "yes" to C.(3) above, are any of the brokers or dealers related persons?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8D']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8D']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td class="align-top">E.</td>
                    <td width="98%">Do you or any related person recommend brokers or dealers to clients?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8E']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8E']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                
                <tr>
                    <td class="align-top">F.</td>
                    <td width="98%">If you answer "yes" to E. above, are any of the brokers or dealers related persons?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8F']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8F']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td class="align-top">G.</td>
                    <td width="98%">(1) Do you or any related person receive research or other products or services other than execution from a broker-dealer or a third party ("soft dollar benefits") in connection with client securities transactions?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8G(1)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8G(1)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td width="98%">(2) If "yes" to G.(1) above, are all the "soft dollar benefits" you or any related persons receive eligible "research or brokerage services" under section 28(e) of the Securities Exchange Act of 1934?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8G(2)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8G(2)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td class="align-top">H.</td>
                    <td width="98%">(1) Do you or any related person, directly or indirectly, compensate any person that is not an employee for client referrals?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8H(1)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8H(1)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td width="98%">(2) Do you or any related person, directly or indirectly, provide any employee compensation that is specifically related to obtaining clients for the firm (cash or non-cash compensation in addition to the employee's regular salary)?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8H(2)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8H(2)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                
                <tr>
                    <td class="align-top">I.</td>
                    <td width="98%">Do you or any related person, including any employee, directly or indirectly, receive compensation from any person (other than you or any related person) for client referrals?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8I']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['8I']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">
                        In your response to Item 8.I., do not include the regular salary you pay to an employee.
                        
                        In responding to Items 8.H. and 8.I., consider all cash and non-cash compensation that you or a related person gave to (in answering Item 8.H.) or received from (in answering Item 8.I.) any person in exchange for client referrals, including any bonus that is based, at least in part, on the number or amount of client referrals.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
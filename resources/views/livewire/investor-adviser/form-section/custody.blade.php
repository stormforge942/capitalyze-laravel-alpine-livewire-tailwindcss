<div class="border border-gray">
    <p class="border-b border-gray bg-gray-100 p-2"><b>Item 9 Custody</b></p>
    <p class="border-b border-gray p-2">In this Item, we ask you whether you or a related person has custody of client (other than clients that are investment companies registered under the Investment Company Act of 1940) assets and about your custodial practices.</p>
    <div class="p-2">
        <table>
            <tbody>
                <tr>
                    <td class="align-top">A.</td>
                    <td class="align-top">(1)</td>
                    <td width="98%">Do you have custody of any advisory clients':</td>
                    <td width="1%">No</td>
                    <td width="1%">Yes</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td width="98%">(a) cash or bank accounts?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['9A(1)(a)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['9A(1)(a)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td width="98%">(b) securities?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['9A(1)(b)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['9A(1)(b)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">If you are registering or registered with the SEC, answer "No" to Item 9.A.(1)(a) and (b) if you have custody solely because (i) you deduct your advisory fees directly from your clients' accounts, or (ii) a related person has custody of client assets in connection with advisory services you provide to clients, but you have overcome the presumption that you are not operationally independent (pursuant to Advisers Act rule 206(4)-2(d)(5)) from the related person.</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="align-top">(2)</td>
                    <td colspan="3">If you checked "yes" to Item 9.A.(1)(a) or (b), what is the approximate amount of client funds and securities and total number of clients for which you have custody:</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="3">
                        <table>
                            <tbody>
                                <tr>
                                    <td>U.S. Dollar Amount</td>
                                    <td>Total Number of Clients</td>
                                </tr>
                                <tr>
                                    <td>(a) ${{ formatAdviserString($adviser['form_data']['9A(2)(a)']) }}</td>
                                    <td>(b) {{ formatAdviserString($adviser['form_data']['9A(2)(b)']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">If you are registering or registered with the SEC and you have custody solely because you deduct your advisory fees directly from your clients' accounts, do not include the amount of those assets and the number of those clients in your response to Item 9.A.(2). If your related person has custody of client assets in connection with advisory services you provide to clients, do not include the amount of those assets and number of those clients in your response to 9.A.(2). Instead, include that information in your response to Item 9.B.(2).</td>
                </tr>
                <tr>
                    <td class="align-top">B.</td>
                    <td class="align-top">(1)</td>
                    <td width="98%">In connection with advisory services you provide to clients, do any of your related persons have custody of any of your advisory clients':</td>
                    <td width="1%">Yes</td>
                    <td width="1%">No</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td width="98%">(a) cash or bank accounts?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['9B(1)(a)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['9B(1)(a)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td width="98%">(b) securities?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['9B(1)(b)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['9B(1)(b)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">You are required to answer this item regardless of how you answered Item 9.A.(1)(a) or (b).</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="align-top">(2)</td>
                    <td colspan="3">If you checked "yes" to Item 9.B.(1)(a) or (b), what is the approximate amount of client funds and securities and total number of clients for which your related persons have custody:</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="3">
                        <table>
                            <tbody>
                                <tr>
                                    <td>U.S. Dollar Amount</td>
                                    <td>Total Number of Clients</td>
                                </tr>
                                <tr>
                                    <td>(a) ${{ formatAdviserString($adviser['form_data']['9B(2)(a)']) }}</td>
                                    <td>(b) {{ formatAdviserString($adviser['form_data']['9B(2)(b)']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="align-top">C.</td>
                    <td colspan="4">If you or your related persons have custody of client funds or securities in connection with advisory services you provide to clients, check all the following that apply:</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="align-top">(1)</td>
                    <td width="98%">A qualified custodian(s) sends account statements at least quarterly to the investors in the pooled investment vehicle(s) you manage.</td>
                    <td width="1%"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['9C(1)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="align-top">(2)</td>
                    <td width="98%">An independent public accountant audits annually the pooled investment vehicle(s) that you manage and the audited financial statements are distributed to the investors in the pools.</td>
                    <td width="1%"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['9C(2)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="align-top">(3)</td>
                    <td width="98%">An independent public accountant conducts an annual surprise examination of client funds and securities.</td>
                    <td width="1%"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['9C(3)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="align-top">(4)</td>
                    <td width="98%">An independent public accountant prepares an internal control report with respect to custodial services when you or your related persons are qualified custodians for client funds and securities.</td>
                    <td width="1%"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['9C(4)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%"></td>
                </tr>
                
                <tr>
                    <td></td>
                    <td colspan="4">If you checked Item 9.C.(2), C.(3) or C.(4), list in Section 9.C. of Schedule D the accountants that are engaged to perform the audit or examination or prepare an internal control report. (If you checked Item 9.C.(2), you do not have to list auditor information in Section 9.C. of Schedule D if you already provided this information with respect to the private funds you advise in Section 7.B.(1) of Schedule D).</td>
                </tr>

                <tr>
                    <td class="align-top">D.</td>
                    <td colspan="2">Do you or your related person(s) act as qualified custodians for your clients in connection with advisory services you provide to clients?</td>
                    <td width="1%">Yes</td>
                    <td width="1%">No</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="align-top">(1)</td>
                    <td width="98%">(a) you act as a qualified custodian</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['9D(1)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['9D(1)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="align-top">(2)</td>
                    <td width="98%">your related person(s) act as qualified custodian(s)</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['9D(2)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['9D(2)']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">If you checked "yes" to Item 9.D.(2), all related persons that act as qualified custodians (other than any mutual fund transfer agent pursuant to rule 206(4)-2(b)(1)) must be identified in Section 7.A. of Schedule D, regardless of whether you have determined the related person to be operationally independent under rule 206(4)-2 of the Advisers Act.</td>
                </tr>
                
                <tr>
                    <td class="align-top">E.</td>
                    <td colspan="4">
                        <p>If you are filing your annual updating amendment and you were subject to a surprise examination by an independent public accountant during your last fiscal year, provide the date (MM/YYYY) the examination commenced:</p>
                        <p class="text-[#f00]">{{ $adviser['form_data']['9E'] == 'None' ? '' : \Carbon\Carbon::parse($adviser['form_data']['9E'])->format('m/Y') }}</p>
                    </td>
                </tr>
                
                <tr>
                    <td class="align-top">F.</td>
                    <td colspan="4">
                        <p>If you or your related persons have custody of client funds or securities, how many persons, including, but not limited to, you and your related persons, act as qualified custodians for your clients in connection with advisory services you provide to clients?</p>
                        <p class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['9F']) }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="border border-gray">
    <p class="border-b border-gray bg-gray-100 p-2"><b>Item 2 SEC Registration/Reporting</b></p>
    <p class="border-b border-gray p-2">Responses to this Item help us (and you) determine whether you are eligible to register with the SEC. Complete this Item 2.A. only if you are applying for SEC registration or submitting an annual updating amendment to your SEC registration. If you are filing an umbrella registration, the information in Item 2 should be provided for the filing adviser only.</p>
    <div class="p-2 border-b">
        <table>
            <tbody>
                <tr>
                    <td class="align-top">A.</td>
                    <td colspan="3">
                        <p>To register (or remain registered) with the SEC, you must check at least one of the Items 2.A.(1) through 2.A.(12), below. If you are submitting an annual updating amendment to your SEC registration and you are no longer eligible to register with the SEC, check Item 2.A.(13). Part 1A Instruction 2 provides information to help you determine whether you may affirmatively respond to each of these items.</p>
                        <p>You (the adviser):</p>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="align-top w-[20px]"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['2A(1)']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="align-top">(1)</td>
                                    <td colspan="2">are a <b>large advisory firm</b> that either:</td>
                                </tr>
                                <tr>
                                    <td></td><td></td>
                                    <td>(a)</td>
                                    <td>has regulatory assets under management of $100 million (in U.S. dollars) or more; or</td>
                                </tr>
                                <tr>
                                    <td></td><td></td>
                                    <td>(b)</td>
                                    <td>has regulatory assets under management of $90 million (in U.S. dollars) or more at the time of filing its most recent annual updating amendment and is registered with the SEC;</td>
                                </tr>
                                <tr>
                                    <td class="align-top"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['2A(2)']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="align-top">(2)</td>
                                    <td colspan="2">are a <b>mid-sized firm</b> that has regulatory assets under management of $25 million (in U.S. dollars) or more but less than $100 million (in U.S. dollars) and you are either:</td>
                                </tr>
                                <tr>
                                    <td></td><td></td>
                                    <td>(a)</td>
                                    <td>not required to be registered as an adviser with the state securities authority of the state where you maintain your principal office and place of business; or</td>
                                </tr>
                                <tr>
                                    <td></td><td></td>
                                    <td>(b)</td>
                                    <td>
                                        <p>not subject to examination by the state securities authority of the state where you maintain your principal office and place of business;</p>
                                        <p>Click HERE for a list of states in which an investment adviser, if registered, would not be subject to examination by the state securities authority.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="align-top">(3)</td>
                                    <td colspan="2">Reserved</td>
                                </tr>
                                <tr>
                                    <td class="align-top"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['2A(4)']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="align-top">(4)</td>
                                    <td colspan="2">have your principal office and place of business <b>outside the United States</b>;</td>
                                </tr>
                                <tr>
                                    <td class="align-top"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['2A(5)']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="align-top">(5)</td>
                                    <td colspan="2">are <b>an investment adviser (or subadviser) to an investment company</b> registered under the Investment Company Act of 1940;</td>
                                </tr>
                                <tr>
                                    <td class="align-top"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['2A(6)']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="align-top">(6)</td>
                                    <td colspan="2">are <b>an investment adviser to a company which has elected to be a business development company</b> pursuant to section 54 of the Investment Company Act of 1940 and has not withdrawn the election, and you have at least $25 million of regulatory assets under management;</td>
                                </tr>
                                <tr>
                                    <td class="align-top"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['2A(7)']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="align-top">(7)</td>
                                    <td colspan="2">are a <b>pension consultant</b> with respect to assets of plans having an aggregate value of at least $200,000,000 that qualifies for the exemption in rule 203A-2(a);</td>
                                </tr>
                                <tr>
                                    <td class="align-top"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['2A(8)']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="align-top">(8)</td>
                                    <td colspan="2">
                                        <p>are a <b>related adviser</b> under rule 203A-2(b) that controls, is controlled by, or is under common control with, an investment adviser that is registered with the SEC, and your principal office and place of business is the same as the registered adviser;</p>
                                        <p>If you check this box, complete Section 2.A.(8) of Schedule D.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-top"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['2A(9)']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="align-top">(9)</td>
                                    <td colspan="2">
                                        <p>are an <b>adviser</b> relying on rule 203A-2(c) because you <b>expect to be eligible for SEC registration within 120 days;</b></p>
                                        <p>If you check this box, complete Section 2.A.(9) of Schedule D.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-top"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['2A(10)']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="align-top">(10)</td>
                                    <td colspan="2">
                                        <p>are a <b>multi-state adviser</b> that is required to register in 15 or more states and is relying on rule 203A-2(d);</p>
                                        <p>If you check this box, complete Section 2.A.(10) of Schedule D.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-top"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['2A(11)']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="align-top">(11)</td>
                                    <td colspan="2">are an <b>Internet adviser</b> relying on rule 203A-2(e);</td>
                                </tr>
                                <tr>
                                    <td class="align-top"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['2A(12)']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="align-top">(12)</td>
                                    <td colspan="2">
                                        <p>have <b>received an SEC order</b> exempting you from the prohibition against registration with the SEC;</p>
                                        <p>If you check this box, complete Section 2.A.(12) of Schedule D.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-top"><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['2A(13)']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="align-top">(13)</td>
                                    <td colspan="2">are <b>no longer eligible</b> to remain registered with the SEC.</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="p-2">
        <table>
            <tbody>
                <tr>
                    <td colspan="4">
                        <p class="m-1 text-bold bg-gray-100"><i>State Securities AuthorityNotice Filings and State Reporting by Exempt Reporting Advisers</i></p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top">C.</td>
                    <td colspan="3">
                        <p>Under state laws, SEC-registered advisers may be required to provide to state securities authorities a copy of the Form ADV and any amendments they file with the SEC. These are called notice filings. In addition, exempt reporting advisers may be required to provide state securities authorities with a copy of reports and any amendments they file with the SEC. If this is an initial application or report, check the box(es) next to the state(s) that you would like to receive notice of this and all subsequent filings or reports you submit to the SEC. If this is an amendment to direct your notice filings or reports to additional state(s), check the box(es) next to the state(s) that you would like to receive notice of this and all subsequent filings or reports you submit to the SEC. If this is an amendment to your registration to stop your notice filings or reports from going to state(s) that currently receive them, uncheck the box(es) next to those state(s).</p>
                        
                        <p>Jurisdictions</p>
                        <?php
                            $states = ['AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'DC', 'FL',
                                'GA', 'GU', 'HI', 'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA',
                                'ME', 'MD', 'MA', 'MI', 'MN', 'MS', 'MO', 'MT', 'NE', 'NV',
                                'NH', 'NJ', 'NM', 'NY', 'NC', 'ND', 'OH', 'OK', 'OR', 'PA',
                                'PR', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT', 'VT', 'VI', 'WA',
                                'WV', 'WI', 'WY'];
                        ?>
                        <table class="border">
                            <tr>
                                <td class="border">
                                    @foreach (array_slice($states, 0, 14) as $state)
                                        <p><img src="{{ asset('img/adv_multi_' . (in_array($state, formatAdviserStates($adviser['form_data']['Jurisdiction Notice Filed-Effective Date'])) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /> {{ $state }}</p>
                                    @endforeach
                                </td>
                                <td class="border">
                                    @foreach (array_slice($states, 14, 14) as $state)
                                    <p><img src="{{ asset('img/adv_multi_' . (in_array($state, formatAdviserStates($adviser['form_data']['Jurisdiction Notice Filed-Effective Date'])) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /> {{ $state }}</p>
                                    @endforeach
                                </td>
                                <td class="border">
                                    @foreach (array_slice($states, 28, 14) as $state)
                                    <p><img src="{{ asset('img/adv_multi_' . (in_array($state, formatAdviserStates($adviser['form_data']['Jurisdiction Notice Filed-Effective Date'])) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /> {{ $state }}</p>
                                    @endforeach
                                </td>
                                <td class="align-top border">
                                    @foreach (array_slice($states, 42, 14) as $state)
                                    <p><img src="{{ asset('img/adv_multi_' . (in_array($state, formatAdviserStates($adviser['form_data']['Jurisdiction Notice Filed-Effective Date'])) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /> {{ $state }}</p>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                        
                        <p>If you are amending your registration to stop your notice filings or reports from going to a state that currently receives them and you do not want to pay that state's notice filing or report filing fee for the coming year, your amendment must be filed before the end of the year (December 31).</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="border border-gray">
    <p class="border-b border-gray bg-gray-100 p-2"><b>Item 5 Information About Your Advisory Business - Employees, Clients, and Compensation</b></p>
    <p class="border-b border-gray p-2">Responses to this Item help us understand your business, assist us in preparing for on-site examinations, and provide us with data we use when making regulatory policy. Part 1A Instruction 5.a. provides additional guidance to newly formed advisers for completing this Item 5.</p>
    <div class="p-2">
        <table>
            <tbody>
                <tr><td class="bg-gray-100 font-bold" colspan="5"><i>Employees</i></td></tr>
                <tr><td colspan="5">If you are organized as a sole proprietorship, include yourself as an employee in your responses to Item 5.A. and Items 5.B.(1), (2), (3), (4), and (5). If an employee performs more than one function, you should count that employee in each of your responses to Items 5.B.(1), (2), (3), (4), and (5).</td></tr>
                <tr>
                    <td class="align-top">A.</td>
                    <td colspan="4">
                        <p>Approximately how many employees do you have? Include full- and part-time employees but do not include any clerical workers.</p>
                        <p class="text-[#f00]">{{ $adviser['form_data']['5A'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top">B.</td>
                    <td class="align-top">(1)</td>
                    <td colspan="3">
                        <p>Approximately how many of the employees reported in 5.A. perform investment advisory functions (including research)?</p>
                        <p class="text-[#f00]">{{ $adviser['form_data']['5B(1)'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top"></td>
                    <td class="align-top">(2)</td>
                    <td colspan="3">
                        <p>Approximately how many of the employees reported in 5.A. are registered representatives of a broker-dealer?</p>
                        <p class="text-[#f00]">{{ $adviser['form_data']['5B(2)'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top"></td>
                    <td class="align-top">(3)</td>
                    <td colspan="3">
                        <p>Approximately how many of the employees reported in 5.A. are registered with one or more state securities authorities as investment adviser representatives?</p>
                        <p class="text-[#f00]">{{ $adviser['form_data']['5B(3)'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top"></td>
                    <td class="align-top">(4)</td>
                    <td colspan="3">
                        <p>Approximately how many of the employees reported in 5.A. are registered with one or more state securities authorities as investment adviser representatives for an investment adviser other than you?</p>
                        <p class="text-[#f00]">{{ $adviser['form_data']['5B(4)'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top"></td>
                    <td class="align-top">(5)</td>
                    <td colspan="3">
                        <p>Approximately how many of the employees reported in 5.A. are licensed agents of an insurance company or agency?</p>
                        <p class="text-[#f00]">{{ $adviser['form_data']['5B(5)'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top"></td>
                    <td class="align-top">(6)</td>
                    <td colspan="3">
                        <p>Approximately how many firms or other persons solicit advisory clients on your behalf?</p>
                        <p class="text-[#f00]">{{ $adviser['form_data']['5B(6)'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top"></td>
                    <td colspan="4">In your response to Item 5.B.(6), do not count any of your employees and count a firm only once – do not count each of the firm's employees that solicit on your behalf.</td>
                </tr>

                <tr><td class="bg-gray-100 font-bold" colspan="5"><i>Clients</i></td></tr>
                <tr><td colspan="5">In your responses to Items 5.C. and 5.D. do not include as "clients" the investors in a private fund you advise, unless you have a separate advisory relationship with those investors.</td></tr>
                <tr>
                    <td class="align-top">C.</td>
                    <td class="align-top">(1)</td>
                    <td colspan="3">
                        <p>To approximately how many clients for whom you do not have regulatory assets under management did you provide investment advisory services during your most recently completed fiscal year?</p>
                        <p class="text-[#f00]">{{ $adviser['form_data']['5C(1)'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top"></td>
                    <td class="align-top">(2)</td>
                    <td colspan="3">
                        <p>Approximately what percentage of your clients are non-United States persons?</p>
                        <p class="text-[#f00]">{{ $adviser['form_data']['5C(2)'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top">D.</td>
                    <td colspan="4">
                        <p><i>For purposes of this Item 5.D., the category "individuals" includes trusts, estates, and 401(k) plans and IRAs of individuals and their family members, but does not include businesses organized as sole proprietorships.</i></p>
                        <p><i>The category "business development companies" consists of companies that have made an election pursuant to section 54 of the Investment Company Act of 1940. Unless you provide advisory services pursuant to an investment advisory contract to an investment company registered under the Investment Company Act of 1940, do not answer (1)(d) or (3)(d) below.</i></p>
                        <p>Indicate the approximate number of your clients and amount of your total regulatory assets under management (reported in Item 5.F. below) attributable to each of the following type of client. If you have fewer than 5 clients in a particular category (other than (d), (e), and (f)) you may check Item 5.D.(2) rather than respond to Item 5.D.(1).</p>
                        <p>The aggregate amount of regulatory assets under management reported in Item 5.D.(3) should equal the total amount of regulatory assets under management reported in Item 5.F.(2)(c) below.</p>
                        <p>If a client fits into more than one category, select one category that most accurately represents the client to avoid double counting clients and assets. If you advise a registered investment company, business development company, or pooled investment vehicle, report those assets in categories (d), (e), and (f) as applicable.</p>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4">
                        <table class="border-collapse border">
                            <thead>
                                <tr>
                                    <th class="border">Type of Client</th>
                                    <th class="border">(1) Number of Client(s)</th>
                                    <th class="border">(2) Fewer than 5 Clients</th>
                                    <th class="border">(3) Amount of Regulatory Assets under Management</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border">(a) Individuals (other than high net worth individuals)</td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(a)(1)']) }}</span></td>
                                    <td class="border"><img src="{{ asset('img/adv_multi_' . ($adviser['form_data']['5D(a)(2)'] == 'None' ? 'un' : '') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(a)(3)']) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="border"><i>(b) High net worth individuals</i></td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(b)(1)']) }}</span></td>
                                    <td class="border"><img src="{{ asset('img/adv_multi_' . ($adviser['form_data']['5D(b)(2)'] == 'None' ? 'un' : '') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(b)(3)']) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="border">(c) Banking or thrift institutions</td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(c)(1)']) }}</span></td>
                                    <td class="border"><img src="{{ asset('img/adv_multi_' . ($adviser['form_data']['5D(c)(2)'] == 'None' ? 'un' : '') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(c)(3)']) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="border">(d) Investment companies</td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(d)(1)']) }}</span></td>
                                    <td class="bg-gray-500"></td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(d)(3)']) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="border">(e) Business development companies</td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(e)(1)']) }}</span></td>
                                    <td class="bg-gray-500"></td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(e)(3)']) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="border">(f) Pooled investment vehicles (other than investment companies and business development companies)</td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(f)(1)']) }}</span></td>
                                    <td class="bg-gray-500"></td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(f)(3)']) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="border">(g) Pension and profit sharing plans (but not the plan participants or government pension plans)</td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(f)(1)']) }}</span></td>
                                    <td class="border"><img src="{{ asset('img/adv_multi_' . ($adviser['form_data']['5D(g)(2)'] == 'None' ? 'un' : '') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(f)(3)']) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="border">(h) Charitable organizations</td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(h)(1)']) }}</span></td>
                                    <td class="border"><img src="{{ asset('img/adv_multi_' . ($adviser['form_data']['5D(h)(2)'] == 'None' ? 'un' : '') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(h)(3)']) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="border">(i) State or municipal government entities (including government pension plans)</td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(i)(1)']) }}</span></td>
                                    <td class="border"><img src="{{ asset('img/adv_multi_' . ($adviser['form_data']['5D(i)(2)'] == 'None' ? 'un' : '') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(i)(3)']) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="border">(j) Other investment advisers</td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(j)(1)']) }}</span></td>
                                    <td class="border"><img src="{{ asset('img/adv_multi_' . ($adviser['form_data']['5D(j)(2)'] == 'None' ? 'un' : '') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(j)(3)']) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="border">(k) Insurance companies</td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(k)(1)']) }}</span></td>
                                    <td class="border"><img src="{{ asset('img/adv_multi_' . ($adviser['form_data']['5D(k)(2)'] == 'None' ? 'un' : '') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(k)(3)']) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="border">(l) Sovereign wealth funds and foreign official institutions</td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(l)(1)']) }}</span></td>
                                    <td class="border"><img src="{{ asset('img/adv_multi_' . ($adviser['form_data']['5D(l)(2)'] == 'None' ? 'un' : '') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(l)(3)']) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="border">(m) Corporations or other businesses not listed above</td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(m)(1)']) }}</span></td>
                                    <td class="border"><img src="{{ asset('img/adv_multi_' . ($adviser['form_data']['5D(m)(2)'] == 'None' ? 'un' : '') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(m)(3)']) }}</span></td>
                                </tr>
                                <tr>
                                    <td class="border">(n) Other:</td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(n)(1)']) }}</span></td>
                                    <td class="border"><img src="{{ asset('img/adv_multi_' . ($adviser['form_data']['5D(n)(2)'] == 'None' ? 'un' : '') . 'checked.gif') }}" class="inline align-middle" /></td>
                                    <td class="border"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['5D(n)(3)']) }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                
                <tr><td class="bg-gray-100 font-bold" colspan="5">Compensation Arrangements</td></tr>
                <tr>
                    <td class="align-top">E.</td>
                    <td colspan="4">You are compensated for your investment advisory services by (check all that apply):</td>
                </tr>
                <tr>
                    <td></td>
                    <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5E(1)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td colspan="3">(1) A percentage of assets under your management</td>
                </tr>
                <tr>
                    <td></td>
                    <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5E(1)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td colspan="3">(1) A percentage of assets under your management</td>
                </tr>
                <tr>
                    <td></td>
                    <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5E(2)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td colspan="3">(2)	Hourly charges</td>
                </tr>
                <tr>
                    <td></td>
                    <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5E(3)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td colspan="3">(3)	Subscription fees (for a newsletter or periodical)</td>
                </tr>
                <tr>
                    <td></td>
                    <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5E(4)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td colspan="3">(4)	Fixed fees (other than subscription fees)</td>
                </tr>
                <tr>
                    <td></td>
                    <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5E(5)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td colspan="3">(5)	Commissions</td>
                </tr>
                <tr>
                    <td></td>
                    <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5E(6)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td colspan="3">(6)	Performance-based fees</td>
                </tr>
                <tr>
                    <td></td>
                    <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5E(7)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td colspan="3">(7) Other (specify):</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

 
<div class="border border-gray">
    <p class="border-b border-gray bg-gray-100 p-2"><b>Item 5 Information About Your Advisory Business - Regulatory Assets Under Management</b></p>
    <table>
        <tbody>
            <tr><td class="bg-gray-100 font-bold" colspan="5"><i>Regulatory Assets Under Management</i></td></tr> 
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td width="1%" class="font-bold">Yes</td>
                <td width="1%" class="font-bold">No</td>
            </tr>
            <tr>
                <td>F.</td>
                <td>(1)</td>
                <td>Do you provide continuous and regular supervisory or management services to securities portfolios?</td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5F(1)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5F(1)']) ? 'un' : '') . 'checked.gif') }}" /></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td colspan="3">If yes, what is the amount of your regulatory assets under management and total number of accounts?</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td colspan="3">
                    <table width="100%" style="text-align: left">
                        <tbody>
                            <tr>
                                <td width="30%"></td>
                                <td width="3%"></td>
                                <td colspan="2"> U.S. Dollar Amount </td>
                                <td> Total Number of Accounts </td>
                            </tr>
                            <tr>
                                <td width="30%"> Discretionary: </td>
                                <td width="3%"> (a) </td>
                                <td width="30%" nowrap=""><span class="text-red">$&nbsp;197,811,480</span></td>
                                <td width="3%"> (d) </td>
                                <td><span class="text-red">458</span></td>
                            </tr>
                            <tr>
                                <td width="30%"> Non-Discretionary: </td>
                                <td width="3%"> (b) </td>
                                <td width="30%"><span class="text-red">$&nbsp;0</span></td>
                                <td width="3%"> (e) </td>
                                <td><span class="text-red">0</span></td>
                            </tr>
                            <tr>
                                <td width="30%"> Total: </td>
                                <td width="3%"> (c) </td>
                                <td width="30%"><span class="text-red">$&nbsp;197,811,480</span></td>
                                <td width="3%"> (f) </td>
                                <td><span class="text-red">458</span></td>
                            </tr>
                            <tr><td colspan="5"></td></tr>
                            <tr><td colspan="5"><i>Part 1A Instruction 5.b. explains how to calculate your regulatory assets under management. You must follow these instructions carefully when completing this Item. </i></td></tr>
                            <tr><td colspan="5"></td></tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>

 
<div class="border border-gray">
    <p class="border-b border-gray bg-gray-100 p-2"><b>Item 5 Information About Your Advisory Business - Advisory Activities</b></p>

    <table>
        <tbody>
            <tr><td class="bg-gray-100 font-bold" colspan="5">Advisory Activities</td></tr> 
            <tr>
                <td>G.</td>
                <td colspan="4">What type(s) of advisory services do you provide? Check all that apply.</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5G(1)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td colspan="3">(1) Financial planning services</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5G(2)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td colspan="3">(2) Portfolio management for individuals and/or small businesses</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5G(3)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td colspan="3">(3) Portfolio management for investment companies (as well as "business development companies" that have made an election pursuant to section 54 of the Investment Company Act of 1940)</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5G(4)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td colspan="3">(4) Portfolio management for pooled investment vehicles (other than investment companies)</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5G(5)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td colspan="3">(5) Portfolio management for businesses (other than small businesses) or institutional clients (other than registered investment companies and other pooled investment vehicles)</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5G(6)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td colspan="3">(6) Pension consulting services</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5G(7)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td colspan="3">(7) Selection of other advisers (including private fund managers)</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5G(8)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td colspan="3">(8) Publication of periodicals or newsletters</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5G(9)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td colspan="3">(9) Security ratings or pricing services</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5G(10)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td colspan="3">(10) Market timing services</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5G(11)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td colspan="3">(11) Educational seminars/workshops</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['5G(12)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td colspan="3">(12) Other(specify):</td>
            </tr> 
            <tr>
                <td></td>
                <td colspan="4">Do not check Item 5.G.(3) unless you provide advisory services pursuant to an investment advisory contract to an investment company registered under the Investment Company Act of 1940, including as a subadviser. If you check Item 5.G.(3), report the 811 or 814 number of the investment company or investment companies to which you provide advice in Section 5.G.(3) of Schedule D.</td>
            </tr> 
            <tr>
                <td>H.</td>
                <td colspan="4">If you provide financial planning services, to how many clients did you provide these services during your last fiscal year?</td>
            </tr>
            <?php
                $integer = formatAdviserInteger($adviser['form_data']['5H']);
            ?>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_radio_' . ($integer == 0 ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                <td colspan="3">0</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_radio_' . (($integer > 0 && $integer <= 10) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                <td colspan="3">1-10</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_radio_' . (($integer > 10 && $integer <= 25) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                <td colspan="3">11-25</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_radio_' . (($integer > 25 && $integer <= 50) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                <td colspan="3">26-50</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_radio_' . (($integer > 50 && $integer <= 100) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                <td colspan="3">51-100</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_radio_' . (($integer > 100 && $integer <= 250) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                <td colspan="3">101-250</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_radio_' . (($integer > 250 && $integer <= 500) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                <td colspan="3">251-500</td>
            </tr>
            <tr>
                <td></td>
                <td><img src="{{ asset('img/adv_radio_' . (($integer > 500) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></td>
                <td colspan="3">More than 500</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td colspan="3">If more than 500, how many? <span class="text-red">{{ formatAdviserString($adviser['form_data']['5H-If more than 500, how many']) }}</span> (round to the nearest 500)</td>
            </tr> 
            <tr>
                <td></td>
                <td colspan="4">In your responses to this Item 5.H., do not include as "clients" the investors in a private fund you advise, unless you have a separate advisory relationship with those investors.</td>
            </tr> 

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Yes</td>
                <td>No</td>
            </tr>
            <tr>
                <td>I.</td>
                <td>(1)</td>
                <td>Do you participate in a wrap fee program?</td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5I(1)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5I(1)']) ? 'un' : '') . 'checked.gif') }}" /></td>
            </tr>
            <tr>
                <td></td>
                <td>(2)</td>
                <td colspan="3">If you participate in a wrap fee program, what is the amount of your regulatory assets under management attributable to acting as:</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" class="pl-3">(a) sponsor to a wrap fee program</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" class="pl-5">$ {{ formatAdviserString($adviser['form_data']['5I(2)(a)']) }}</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" class="pl-3">(b) portfolio manager for a wrap fee program?</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" class="pl-5">$ {{ formatAdviserString($adviser['form_data']['5I(2)(b)']) }}</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" class="pl-3">(c) sponsor to and portfolio manager for the same wrap fee program?</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4" class="pl-5">$ {{ formatAdviserString($adviser['form_data']['5I(2)(c)']) }}</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4">If you report an amount in Item 5.I.(2)(c), do not report that amount in Item 5.I.(2)(a) or Item 5.I.(2)(b).</td>
            </tr> 
            <tr>
                <td></td>
                <td colspan="4">If you are a portfolio manager for a wrap fee program, list the names of the programs, their sponsors and related information in Section 5.I.(2) of Schedule D.</td>
            </tr> 
            <tr>
                <td></td>
                <td colspan="4">If your involvement in a wrap fee program is limited to recommending wrap fee programs to your clients, or you advise a mutual fund that is offered through a wrap fee program, do not check Item 5.I.(1) or enter any amounts in response to Item 5.I.(2).</td>
            </tr> 
            <tr>
                <td>K.</td>
                <td colspan="4">Separately Managed Account Clients</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Yes</td>
                <td>No</td>
            </tr>
            <tr>
                <td></td>
                <td class="align-top">(1)</td>
                <td>Do you have regulatory assets under management attributable to clients other than those listed in Item 5.D.(3)(d)-(f) (separately managed account clients)?</td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5K(1)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5K(1)']) ? 'un' : '') . 'checked.gif') }}" /></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4">If yes, complete Section 5.K.(1) of Schedule D.</td>
            </tr>
            <tr>
                <td></td>
                <td class="align-top">(2)</td>
                <td>Do you engage in borrowing transactions on behalf of any of the separately managed account clients that you advise?</td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5K(2)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5K(2)']) ? 'un' : '') . 'checked.gif') }}" /></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4">If yes, complete Section 5.K.(2) of Schedule D.</td>
            </tr>
            <tr>
                <td></td>
                <td class="align-top">(3)</td>
                <td>Do you engage in derivative transactions on behalf of any of the separately managed account clients that you advise?</td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5K(3)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5K(3)']) ? 'un' : '') . 'checked.gif') }}" /></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4">If yes, complete Section 5.K.(2) of Schedule D.</td>
            </tr>
            <tr>
                <td></td>
                <td class="align-top">(4)</td>
                <td>After subtracting the amounts in Item 5.D.(3)(d)-(f) above from your total regulatory assets under management, does any custodian hold ten percent or more of this remaining amount of regulatory assets under management?</td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5K(4)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5K(4)']) ? 'un' : '') . 'checked.gif') }}" /></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="4">If yes, complete Section 5.K.(3) of Schedule D for each custodian.</td>
            </tr> 

            <tr>
                <td>L.</td>
                <td colspan="4">Marketing Activities</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Yes</td>
                <td>No</td>
            </tr>
            <tr>
                <td></td>
                <td>(1)</td>
                <td colspan="3">Do any of your advertisements include:</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" class="pl-3">(a) Performance results?</td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(1)(a)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(1)(a)']) ? 'un' : '') . 'checked.gif') }}" /></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" class="pl-3">(b) A reference to specific investment advice provided by you (as that phrase is used in rule 206(4)-1(a)(5))?</td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(1)(b)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(1)(b)']) ? 'un' : '') . 'checked.gif') }}" /></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" class="pl-3">(a) Performance results?</td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(1)(a)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(1)(a)']) ? 'un' : '') . 'checked.gif') }}" /></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" class="pl-3">(c) Testimonials (other than those that satisfy rule 206(4)-1(b)(4)(ii))?</td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(1)(c)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(1)(c)']) ? 'un' : '') . 'checked.gif') }}" /></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" class="pl-3">(d) Endorsements (other than those that satisfy rule 206(4)-1(b)(4)(ii))?</td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(1)(d)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(1)(d)']) ? 'un' : '') . 'checked.gif') }}" /></td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" class="pl-3">(e) Third-party ratings?</td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(1)(e)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(1)(e)']) ? 'un' : '') . 'checked.gif') }}" /></td>
            </tr>
            <tr>
                <td></td>
                <td>(2)</td>
                <td>If you answer "yes" to L(1)(c), (d), or (e) above, do you pay or otherwise provide cash or non-cash compensation, directly or indirectly, in connection with the use of testimonials, endorsements, or third-party ratings?</td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(2)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(2)']) ? 'un' : '') . 'checked.gif') }}" /></td>
            </tr>
            <tr>
                <td></td>
                <td>(3)</td>
                <td>Do any of your advertisements include hypothetical performance ?</td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(3)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(3)']) ? 'un' : '') . 'checked.gif') }}" /></td>
            </tr>
            <tr>
                <td></td>
                <td>(4)</td>
                <td>Do any of your advertisements include predecessor performance ?</td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(4)']) ? '' : 'un') . 'checked.gif') }}" /></td>
                <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['5L(4)']) ? 'un' : '') . 'checked.gif') }}" /></td>
            </tr>
        </tbody>
    </table>
</div>
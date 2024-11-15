<div class="border border-gray">
    <p class="border-b border-gray bg-gray-100 p-2 font-bold">Item 1 Identifying Information</p>
    <p class="border-b border-gray p-2">Responses to this Item tell us who you are, where you are doing business, and how we can contact you. If you are filing an <i>umbrella registration</i>, the information in Item 1 should be provided for the <i>filing adviser</i> only. General Instruction 5 provides information to assist you with filing an <i>umbrella registration</i>.</p>
    <div class="p-2">
        <table>
            <tbody>
                <tr>
                    <td class="align-top">A.</td>
                    <td colspan="3">
                        <p>Your full legal name (if you are a sole proprietor, your last, first, and middle names):</p>
                        <p class="font-bold text-[#f00]">{{ $adviser['form_data']['Legal Name'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top">B.</td>
                    <td colspan="3">
                        <p>(1) Name under which you primarily conduct your advisory business, if different from Item 1.A.</p>
                        <p class="font-bold text-[#f00]">{{ $adviser['form_data']['Primary Business Name'] }}</p> 
                        <p>List on Section 1.B. of Schedule D any additional names under which you conduct your advisory business.</p>
                        <p>(2) If you are using this Form ADV to register more than one investment adviser under an umbrella registration, check this box
                            <img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['Umbrella Registration']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></p>
                        <p>If you check this box, complete a Schedule R for each <i>relying adviser</i>.</p> 
                    </td>
                </tr>
                <tr>
                    <td class="align-top">C.</td>
                    <td colspan="3">
                        <p>If this filing is reporting a change in your legal name (Item 1.A.) or primary business name (Item 1.B.(1)), enter the new name and specify whether the name change is of</p>
                        <p>
                            <img src="{{ asset('img/adv_multi_unchecked.gif') }}" class="inline align-middle" />your legal name or
                            <img src="{{ asset('img/adv_multi_unchecked.gif') }}" class="inline align-middle" />your primary business name:
                        </p>
                        
                    </td>
                </tr>
                <tr>
                    <td class="align-top">D.</td>
                    <td colspan="3">
                        <p>(1) If you are registered with the SEC as an investment adviser, your SEC file number: <span class="font-bold text-[#f00]">{{ $adviser['form_data']['SEC#'] }}</span></p>
                        <p>(2) If you report to the SEC as an <i>exempt reporting adviser</i>, your SEC file number:</p>
                        <p>(3) If you have one or more Central Index Key numbers assigned by the SEC ("CIK Numbers"), all of your CIK numbers:</p>
                        <p class="text-center">No information filed</p>
                        
                    </td>
                </tr>
                <tr>
                    <td class="align-top">E.</td>
                    <td colspan="3">
                        <p>(1) If you have a number ("<i>CRD Number</i>") assigned by the <i>FINRA's CRD</i> system or by the IARD system, your <i>CRD number</i>: <span class="font-bold text-[#f00]">{{ $adviser['form_data']['Organization CRD#'] }}</span></p> 
                        <p>If your firm does not have a <i>CRD number</i>, skip this Item 1.E. Do not provide the <i>CRD number</i> of one of your officers, <i>employees</i>, or affiliates.</p> 
                        <p>(2) If you have additional <i>CRD Numbers</i>, your additional CRD numbers:</p>
                        @if ($adviser['form_data']['Total number of additional CRD numbers'] == 'None')
                            <p class="text-center">No information filed</p> 
                        @else
                            <p class="text-center"><span class="font-bold text-[#f00]">{{ $adviser['form_data']['Additional CRD Number'] }}</span></p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="align-top">F.</td>
                    <td colspan="3">
                        <p>(1)	Address (do not use a P.O. Box):</p>
                        <table>
                            <tbody>
                                <tr>
                                    <td colspan="2">Number and Street 1:</td>
                                    <td colspan="2">Number and Street 2:</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Main Office Street Address 1']) }}</td>
                                    <td colspan="2" class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Main Office Street Address 2']) }}</td>
                                </tr>
                                <tr>
                                    <td>City:</td>
                                    <td>State:</td>
                                    <td>Country:</td>
                                    <td>ZIP+4/Postal Code:</td>
                                </tr>
                                <tr>
                                    <td class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Main Office City']) }}</td>
                                    <td class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Main Office State']) }}</td>
                                    <td class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Main Office Country']) }}</td>
                                    <td class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Main Office Postal Code']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <p>If this address is a private residence, check this box: <img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['Main Office Private Residence Flag']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></p>
                        <p>List on Section 1.F. of Schedule D any office, other than your principal office and place of business, at which you conduct investment advisory business. If you are applying for registration, or are registered, with one or more state securities authorities, you must list all of your offices in the state or states to which you are applying for registration or with whom you are registered. If you are applying for SEC registration, if you are registered only with the SEC, or if you are reporting to the SEC as an exempt reporting adviser, list the largest twenty-five offices in terms of numbers of employees as of the end of your most recently completed fiscal year.</p>

                        <p>(2) Days of week that you normally conduct business at your principal office and place of business:</p>
                        <p class="pl-5"><img src="{{ asset('img/adv_radio_checked.gif') }}" class="inline align-middle" />Monday-Friday <img src="{{ asset('img/adv_radio_unchecked.gif') }}" class="inline align-middle" />Other:</p>
                        <p class="pl-5">Normal business hours at this location:</p>
                        <p class="pl-5 text-[#f00]">9:00 AM - 5:00 PM</p>

                        <p>(3) Telephone number at this location:</p>
                        <p class="pl-5 text-[#f00]">{{ formatAdviserString($adviser['form_data']['Main Office Telephone Number']) }}</p>

                        <p>(4) Facsimile number at this location, if any:</p>
                        <p class="pl-5 text-[#f00]">{{ formatAdviserString($adviser['form_data']['Main Office Facsimile Number']) }}</p>

                        <p>(5) What is the total number of offices, other than your principal office and place of business, at which you conduct investment advisory business as of the end of your most recently completed fiscal year?</p>
                        <p class="pl-5 text-[#f00]">{{ $adviser['form_data']['Total number of offices, other than your Principal Office and place of business'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top">G.</td>
                    <td colspan="3">
                        <p>Mailing address, if different from your principal office and place of business address:</p>

                        <table>
                            <tbody>
                                <tr>
                                    <td colspan="2">Number and Street 1:</td>
                                    <td colspan="2">Number and Street 2:</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Mail Office Street Address 1']) }}</td>
                                    <td colspan="2" class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Mail Office Street Address 2']) }}</td>
                                </tr>
                                <tr>
                                    <td>City:</td>
                                    <td>State:</td>
                                    <td>Country:</td>
                                    <td>ZIP+4/Postal Code:</td>
                                </tr>
                                <tr>
                                    <td class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Mail Office City']) }}</td>
                                    <td class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Mail Office State']) }}</td>
                                    <td class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Mail Office Country']) }}</td>
                                    <td class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Mail Office Postal Code']) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <p>If this address is a private residence, check this box: <img src="{{ asset('img/adv_multi_' . (formatAdviserBoolean($adviser['form_data']['Mail Office Private Residence Flag']) ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" /></p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top">H.</td>
                    <td colspan="3">
                        <p>If you are a sole proprietor, state your full residence address, if different from your principal office and place of business address in Item 1.F.:</p>

                        <table>
                            <tbody>
                                <tr>
                                    <td colspan="2">Number and Street 1:</td>
                                    <td colspan="2">Number and Street 2:</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-[#f00]"></td>
                                    <td colspan="2" class="text-[#f00]"></td>
                                </tr>
                                <tr>
                                    <td>City:</td>
                                    <td>State:</td>
                                    <td>Country:</td>
                                    <td>ZIP+4/Postal Code:</td>
                                </tr>
                                <tr>
                                    <td class="text-[#f00]"></td>
                                    <td class="text-[#f00]"></td>
                                    <td class="text-[#f00]"></td>
                                    <td class="text-[#f00]"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td width="98%"></td>
                    <td class="text-center" width="1%"><b>Yes</b></td>
                    <td class="text-center" width="1%"><b>No</b></td>
                </tr>
                <tr>
                    <td class="align-top">I.</td>
                    <td width="98%">Do you have one or more websites or accounts on publicly available social media platforms (including, but not limited to, Twitter, Facebook and LinkedIn)?	</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['1I']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['1I']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">
                        If "yes," list all firm website addresses and the address for each of the firm's accounts on publicly available social media platforms on Section 1.I. of Schedule D. If a website address serves as a portal through which to access other information you have published on the web, you may list the portal without listing addresses for all of the other information. You may need to list more than one portal address. Do not provide the addresses of websites or accounts on publicly available social media platforms where you do not control the content. Do not provide the individual electronic mail (e-mail) addresses of employees or the addresses of employee accounts on publicly available social media platforms.
                    </td>
                </tr>
                <tr>
                    <td class="align-top">J.</td>
                    <td colspan="3">
                        <p>Chief Compliance Officer</p>
                        <p>(1) Provide the name and contact information of your Chief Compliance Officer. If you are an exempt reporting adviser, you must provide the contact information for your Chief Compliance Officer, if you have one. If not, you must complete Item 1.K. below.</p>

                        <table>
                            <tbody>
                                <tr>
                                    <td colspan="2">Name:</td>
                                    <td colspan="2">Other titles, if any:</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Chief Compliance Officer Name']) }}</span></td>
                                    <td colspan="2"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Chief Compliance Officer Other Titles']) }}</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Telephone number:</td>
                                    <td colspan="2">Facsimile number, if any:</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Chief Compliance Officer Telephone']) }}</span></td>
                                    <td colspan="2"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Chief Compliance Officer Facsimile']) }}</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Number and Street 1:</td>
                                    <td colspan="2">Number and Street 2:</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Chief Compliance Officer Street Address 1']) }}</span></td>
                                    <td colspan="2"><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Chief Compliance Officer Street Address 2']) }}</span></td>
                                </tr>
                                <tr>
                                    <td>City:</td>
                                    <td>State:</td>
                                    <td>Country:</td>
                                    <td>ZIP+4/Postal Code:</td>
                                </tr>
                                <tr>
                                    <td><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Chief Compliance Officer City']) }}</span></td>
                                    <td><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Chief Compliance Officer State']) }}</span></td>
                                    <td><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Chief Compliance Officer Country']) }}</span></td>
                                    <td><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Chief Compliance Officer Postal Code']) }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                        <p>Electronic mail (e-mail) address, if Chief Compliance Officer has one: <span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Chief Compliance Officer E-mail']) }}</span></p>
                        
                        <p>(2) If your Chief Compliance Officer is compensated or employed by any person other than you, a related person or an investment company registered under the Investment Company Act of 1940 that you advise for providing chief compliance officer services to you, provide the person's name and IRS Employer Identification Number (if any):</p>
                        <p>Name: <span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['Name of the other person compensating CCO']) }}</span></p>
                        <p>IRS Employer Identification Number: <span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['EIN of the Other person compensating CCO']) }}</span></p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top">K.</td>
                    <td>
                        <p>Additional Regulatory Contact Person: If a person other than the Chief Compliance Officer is authorized to receive information and respond to questions about this Form ADV, you may provide that information here.</p>

                        <table>
                            <tbody>
                                <tr>
                                    <td colspan="2">Name: <span class="text-[#f00]"></span></td>
                                    <td colspan="2">Other titles, if any: <span class="text-[#f00]"></span></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Telephone number: <span class="text-[#f00]"></span></td>
                                    <td colspan="2">Facsimile number, if any: <span class="text-[#f00]"></span></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Number and Street 1: <span class="text-[#f00]"></span></td>
                                    <td colspan="2">Number and Street 2: <span class="text-[#f00]"></span></td>
                                </tr>
                                <tr>
                                    <td>City: <span class="text-[#f00]"></span></td>
                                    <td>State: <span class="text-[#f00]"></span></td>
                                    <td>Country: <span class="text-[#f00]"></span></td>
                                    <td>ZIP+4/Postal Code: <span class="text-[#f00]"></span></td>
                                </tr>
                            </tbody>
                        </table>
                        <p>Electronic mail (e-mail) address, if contact person has one:</p>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td width="98%"></td>
                    <td class="text-center" width="1%"><b>Yes</b></td>
                    <td class="text-center" width="1%"><b>No</b></td>
                </tr>
                <tr>
                    <td class="align-top">L.</td>
                    <td width="98%">Do you maintain some or all of the books and records you are required to keep under Section 204 of the Advisers Act, or similar state law, somewhere other than your principal office and place of business?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['1L']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['1L']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">If "yes," complete Section 1.L. of Schedule D.</td>
                </tr>
                <tr>
                    <td></td>
                    <td width="98%"></td>
                    <td class="text-center" width="1%"><b>Yes</b></td>
                    <td class="text-center" width="1%"><b>No</b></td>
                </tr>
                <tr>
                    <td class="align-top">M.</td>
                    <td width="98%">Are you registered with a foreign financial regulatory authority?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['1M']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['1M']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">Answer "no" if you are not registered with a foreign financial regulatory authority, even if you have an affiliate that is registered with a foreign financial regulatory authority. If "yes," complete Section 1.M. of Schedule D.</td>
                </tr>
                <tr>
                    <td></td>
                    <td width="98%"></td>
                    <td class="text-center" width="1%"><b>Yes</b></td>
                    <td class="text-center" width="1%"><b>No</b></td>
                </tr>
                <tr>
                    <td class="align-top">N.</td>
                    <td width="98%">Are you a public reporting company under Sections 12 or 15(d) of the Securities Exchange Act of 1934?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['1N']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['1N']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td width="98%"></td>
                    <td class="text-center" width="1%"><b>Yes</b></td>
                    <td class="text-center" width="1%"><b>No</b></td>
                </tr>
                <tr>
                    <td class="align-top">O.</td>
                    <td width="98%">Did you have $1 billion or more in assets on the last day of your most recent fiscal year?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['1O']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['1O']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">
                        <p>If yes, what is the approximate amount of your assets:</p>
                        <p><img src="{{ asset('img/adv_radio_' . (formatAdviserString($adviser['form_data']['1O - If yes, approx. amount of assets']) == '$1 billion - $10 billion' ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" />$1 billion to less than $10 billion</p>
                        <p><img src="{{ asset('img/adv_radio_' . (formatAdviserString($adviser['form_data']['1O - If yes, approx. amount of assets']) == '$10 billion - $50 billion' ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" />$10 billion to less than $50 billion</p>
                        <p><img src="{{ asset('img/adv_radio_' . (formatAdviserString($adviser['form_data']['1O - If yes, approx. amount of assets']) == 'More than $50 billion' ? '' : 'un') . 'checked.gif') }}" class="inline align-middle" />$50 billion or more</p>
                        
                        <p>For purposes of Item 1.O. only, "assets" refers to your total assets, rather than the assets you manage on behalf of clients. Determine your total assets using the total assets shown on the balance sheet for your most recent fiscal year end.</p>

                        <p>{{ formatAdviserString($adviser['form_data']['1O - If yes, approx. amount of assets']) }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="align-top">P.</td>
                    <td colspan="3">
                        <p>Provide your Legal Entity Identifier if you have one:</p>
                        <p><span class="text-[#f00]">{{ formatAdviserString($adviser['form_data']['1P']) }}</span></p>
                        <p>A legal entity identifier is a unique number that companies use to identify each other in the financial marketplace. You may not have a legal entity identifier.</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
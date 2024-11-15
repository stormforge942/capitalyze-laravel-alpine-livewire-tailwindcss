<div class="border border-gray">
    <p class="border-b border-gray bg-gray-100 p-2"><b>Item 10 Control Persons</b></p>
    <p class="border-b border-gray p-2">In this Item, we ask you to identify every person that, directly or indirectly, controls you. If you are filing an umbrella registration, the information in Item 10 should be provided for the filing adviser only.</p>
    <div class="p-2">
        <table>
            <tbody>
                <tr>
                    <td colspan="4">If you are submitting an initial application or report, you must complete Schedule A and Schedule B. Schedule A asks for information about your direct owners and executive officers. Schedule B asks for information about your indirect owners. If this is an amendment and you are updating information you reported on either Schedule A or Schedule B (or both) that you filed with your initial application or report, you must complete Schedule C.</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td width="1%">Yes</td>
                    <td width="1%">No</td>
                </tr>
                <tr>
                    <td class="align-top">A.</td>
                    <td width="98%">Does any person not named in Item 1.A. or Schedules A, B, or C, directly or indirectly, control your management or policies?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['10A']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['10A']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">If yes, complete Section 10.A. of Schedule D.</td>
                </tr>
                <tr>
                    <td class="align-top">B.</td>
                    <td colspan="3">If any person named in Schedules A, B, or C or in Section 10.A. of Schedule D is a public reporting company under Sections 12 or 15(d) of the Securities Exchange Act of 1934, please complete Section 10.B. of Schedule D.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
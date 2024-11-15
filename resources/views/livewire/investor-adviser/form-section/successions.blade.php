<div class="border border-gray">
    <p class="border-b border-gray bg-gray-100 p-2"><b>Item 4 Successions</b></p>
    <div class="p-2">
        <table>
            <tbody>
                <tr>
                    <td></td>
                    <td width="98%"></td>
                    <td class="text-center" width="1%"><b>Yes</b></td>
                    <td class="text-center" width="1%"><b>No</b></td>
                </tr>
                <tr>
                    <td class="align-top">A.</td>
                    <td width="98%">Are you, at the time of this filing, succeeding to the business of a registered investment adviser, including, for example, a change of your structure or legal status (e.g., form of organization or state of incorporation)?</td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['4A']) ? '' : 'un') . 'checked.gif') }}" /></td>
                    <td width="1%" class="align-top"><img src="{{ asset('img/adv_radio_' . (formatAdviserBoolean($adviser['form_data']['4A']) ? 'un' : '') . 'checked.gif') }}" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">If "yes", complete Item 4.B. and Section 4 of Schedule D.</td>
                </tr>
                <tr>
                    <td class="align-top">B.</td>
                    <td colspan="3">
                        <p>Date of Succession: {{ $adviser['form_data']['4B'] == 'None' ? 'MM/DD/YYYY' : $adviser['form_data']['4B'] }}</p>
                        <p>	If you have already reported this succession on a previous Form ADV filing, do not report the succession again. Instead, check "No." See Part 1A Instruction 4.</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
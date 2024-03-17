<div class="w-full p-2">
    <table class="text-right">
        <tr class="border-b border-gray-300">
            <td></td>
            @foreach ($tableDates as $date)
                <td class="p-3 font-bold">{{ $date }}</td>
            @endforeach
        </tr>
        @foreach ($rows as $row)
            <tr class="border-b border-gray-300 last:border-b-0">
                <td class="py-3 text-left font-semibold block">{{ $row['title'] }}</td>
                @foreach ($row['values'] as $value)
                    <td class="py-3 pl-2">
                        <div>
                            @php
                                $res = str_replace(',', '', $value['value']);
                                if (is_numeric($res)) {
                                    if ($res < 0) {
                                        $res = number_format(abs($res), user_decimal_places(2));
                                        $res = "($res)";
                                    } else {
                                        $res = number_format($res, user_decimal_places(2));
                                    }
                                }
                            @endphp
                            <span @click.prevent="Livewire.emit('left-slide.open', @js($this->generateAttribute($value)))"
                                class="open-slide cursor-pointer hover:underline {{ $res < 0 ? 'text-red' : 'text-black' }}">{{ $res }}</span>
                        </div>
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
</div>

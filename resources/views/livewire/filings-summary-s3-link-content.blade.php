<x-wire-elements-pro::tailwind.slide-over>
    <div wire:init="load">
        <div class="place-items-center" wire:loading.grid>
            <span class="mx-auto simple-loader text-blue"></span>
        </div>

        <div wire:loading.remove>
            @if (!$url)
                <div class="text-center text-gray-500">
                    No content found
                </div>
            @else
                @php $id = \Str::random(10); @endphp
                <div id="{{ $id }}">

                </div>
                <script>
                    fetch(`{{ $url }}`, {
                            mode: 'cors',
                        })
                        .then(response => response.text())
                        .then(data => {
                            const container = document.getElementById('{{ $id }}')
                            container.style.display = 'none';
                            container.innerHTML = data;

                            const tables = container.querySelectorAll('table[summary]');

                            if (!tables.length) return;

                            const lastTable = tables[tables.length - 1];

                            if (!lastTable) {
                                return;
                            }

                            const headers = [];
                            const rows = [];

                            [...lastTable.querySelectorAll('tr')].forEach((row, idx) => {
                                const cells = [...row.querySelectorAll('td, th')]

                                // headers
                                if (idx < 3) {
                                    headers.push(cells.map(cell => {
                                        return {
                                            content: cell.innerText,
                                            colspan: cell.getAttribute('colspan') || 1,
                                            align: {
                                                FormTextR: 'right',
                                                FormTextC: 'center',
                                            } [cell.getAttribute('class')] || 'left'
                                        }
                                    }))
                                    return;
                                }

                                rows.push(cells.map(cell => cell.innerText))
                            });
                            lastTable.remove();

                            container.appendChild(
                                generateTable({
                                        headers,
                                        rows,
                                    },
                                    1,
                                    '{{ $name_of_issuer }}'
                                )
                            );
                            container.style.display = 'block';
                        })
                        .catch(error => {
                            console.error('Error:', error)
                        })

                    function generateTable(data, page, find = null) {
                        const PAGE_SIZE = 20;

                        const table = document.createElement('table');
                        table.style.textAlign = 'left';

                        const thead = document.createElement('thead');
                        const tbody = document.createElement('tbody');

                        data.headers.forEach(row => {
                            const tr = document.createElement('tr');

                            row.forEach(cell => {
                                const th = document.createElement('th');
                                th.innerText = cell.content;
                                th.setAttribute('colspan', cell.colspan);
                                th.style.textAlign = cell.align;
                                tr.appendChild(th);
                            });

                            thead.appendChild(tr);
                        });

                        table.appendChild(thead);

                        const numberOfPages = Math.ceil(data.rows.length / PAGE_SIZE);

                        // find page which contains the find in cell 0
                        if (find) {
                            for (let i = 0; i < data.rows.length; i++) {
                                if (data.rows[i][0].toLowerCase().includes(find.toLowerCase())) {
                                    page = Math.ceil((i + 1) / PAGE_SIZE);
                                    break;
                                }
                            }
                        }

                        const range = {
                            start: (page - 1) * PAGE_SIZE,
                            end: page * PAGE_SIZE,
                        };

                        for (let i = range.start; i < range.end; i++) {
                            const tr = document.createElement('tr');
                            const row = data.rows[i];

                            if (!row) break;

                            let highlight = false;

                            row.forEach((cell, idx) => {
                                const td = document.createElement('td');
                                td.style.textAlign = data.headers[2][idx].align;

                                const span = document.createElement('span');
                                span.innerText = cell;
                                if (!highlight && find && cell.toLowerCase() === find.toLowerCase()) {
                                    highlight = true;
                                }
                                if (highlight && cell.trim()) {
                                    span.style.backgroundColor = 'yellow';
                                }
                                td.appendChild(span);

                                tr.appendChild(td);
                            });

                            tbody.appendChild(tr);
                        }

                        table.appendChild(tbody);

                        return table
                    }

                    function generatePaginationButton(numberOfPages, active) {
                        
                    }
                </script>
            @endif
        </div>
    </div>
</x-wire-elements-pro::tailwind.slide-over>

@php $id = \Str::random(10); @endphp

<x-wire-elements-pro::tailwind.slide-over>
    <div wire:init="load">
        <div class="grid place-items-center" id="{{ $id }}-loader">
            <span class="mx-auto simple-loader text-blue"></span>
        </div>

        <div wire:loading.remove>
            @if (!$url)
                <div class="text-center text-gray-500">
                    No content found
                </div>
            @else
                <div id="{{ $id }}">

                </div>
                <script>
                    const getResponse = (url) => {
                        return fetch(url, {
                                mode: 'cors',
                                // if possible get from cache
                                cache: 'force-cache'
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }

                                return response.text();
                            })
                    }

                    getResponse('{{ $url }}')
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
                                    '{{ $name_of_issuer }}',
                                    true
                                )
                            );

                            window.addEventListener('{{ $id }}', (e) => {
                                container.children[container.children.length - 1].remove();
                                container.appendChild(
                                    generateTable({
                                            headers,
                                            rows,
                                        },
                                        e.detail.page,
                                        '{{ $name_of_issuer }}'
                                    )
                                );
                            });

                            container.style.display = 'block';
                        })
                        .catch(error => {
                            alert('An error occurred while fetching the content')
                            console.error('Error:', error)
                        })
                        .finally(() => {
                            document.getElementById('{{ $id }}-loader').remove();
                        });

                    function generateTable(data, page, find = null, first = false) {
                        const PAGE_SIZE = 20;

                        const table = document.createElement('table');
                        table.classList.add('w-full', 'filing-summary-table')
                        table.style.textAlign = 'left';

                        const thead = document.createElement('thead');
                        const tbody = document.createElement('tbody');

                        data.headers.forEach((row, idx) => {
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

                        let highlightPages = [];

                        // find page which contains the find in cell 0
                        for (let i = 0; i < data.rows.length; i++) {
                            if (data.rows[i][0].toLowerCase().includes(find.toLowerCase())) {
                                highlightPages.push(Math.ceil((i + 1) / PAGE_SIZE));
                            }
                        }

                        if (find && first && highlightPages.length) {
                            page = highlightPages[0];
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

                        const pagination = generationPagination(numberOfPages, page, [...new Set(highlightPages)]);

                        const div = document.createElement('div');
                        div.appendChild(table);
                        if (pagination) {
                            div.appendChild(pagination);
                        }

                        return div
                    }

                    function generationPagination(numberOfPages, active, highlightPages) {
                        if (numberOfPages <= 1) return;

                        const wid = new window.UrlWindow(numberOfPages, active).get()

                        const els = [
                                'Previous',
                                wid.first,
                                Array.isArray(wid.slider) ? '...' : null,
                                wid.slider,
                                Array.isArray(wid.last) ? '...' : null,
                                wid.last,
                                'Next'
                            ].filter(Boolean)
                            .flat()
                            .map((el) => {
                                let result = {
                                    label: el,
                                    disabled: false,
                                    active: Number(el) === active,
                                };

                                if (
                                    (el === 'Previous' && active === 1) ||
                                    (el === 'Next' && active === numberOfPages) ||
                                    el === '...' ||
                                    el === active
                                ) {
                                    result.disabled = true;
                                }

                                return result;
                            });

                        const paginationContainer = document.createElement('div');
                        paginationContainer.classList.add('flex', 'justify-center', 'py-4');

                        els.forEach((el, idx) => {
                            const button = document.createElement('button');
                            if (el.label === 'Previous') {
                                button.innerHTML = `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>`
                            } else if (el.label === 'Next') {
                                button.innerHTML = `<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                                    </svg>`
                            } else {
                                button.innerText = el.label;
                            }

                            button.classList.add(...
                                'relative inline-flex items-center py-2 -ml-px text-sm font-medium border border-gray-300 leading-5 transition ease-in-out duration-150 disabled:pointer-events-none disabled:text-gray-700 disabled:cursor-not-allowed'
                                .split(' '));

                            if (idx === 0) {
                                button.classList.add('rounded-l-md', 'px-2');
                            } else if (idx === els.length - 1) {
                                button.classList.add('rounded-r-md', 'px-2');
                            } else {
                                button.classList.add('px-4');
                            }

                            if (el.active) {
                                button.classList.add('!text-white', 'bg-blue');
                            } else {
                                if (highlightPages.includes(el.label)) {
                                    button.style.backgroundColor = 'yellow';
                                }

                                button.classList.add(...
                                    'hover:bg-gray-light focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300'
                                    .split(' '));
                            }

                            if (el.disabled) {
                                button.disabled = true;
                            }

                            const goToPage = (page) => window.dispatchEvent(new CustomEvent('{{ $id }}', {
                                detail: {
                                    page
                                }
                            }))

                            button.addEventListener('click', () => {
                                if (el.label === 'Previous') {
                                    if (active <= 1) return;

                                    goToPage(active - 1)
                                } else if (el.label === 'Next') {
                                    if (active >= numberOfPages) return;

                                    goToPage(active + 1)
                                } else if (el.label === '...') {
                                    return;
                                } else {
                                    goToPage(Number(el.label))
                                }
                            });

                            paginationContainer.appendChild(button);
                        });

                        return paginationContainer;
                    }
                </script>
            @endif
        </div>
    </div>
</x-wire-elements-pro::tailwind.slide-over>

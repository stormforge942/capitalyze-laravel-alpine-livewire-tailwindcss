<div class="cards-wrapper wide-cards-wrapper">
    <div class="white-card">
        <div class="title">
            <div>Company Profile</div>
            <a href="#" wire:click="toggleFullProfile()" class="title-spoiler">@if ($showFullProfile) Hide full profile @else View full profile @endif</a>
        </div>
        <div class="key-values-wrapper">
            <div class="key-value">
                <div class="key">SIC</div>
                <div class="value">{{ @$profile['sic_description'] ?: '-' }}</div>
            </div>

            <div class="key-value">
                <div class="key">Current C.E.O</div>
                <div class="value">{{ @$profile['ceo'] ?: '-' }}</div>
            </div>

            <div class="key-value">
                <div class="key">Location - HQ</div>
                <div class="value">
                    {{ @$profile['city'] }}@if (@$profile['country'] && @$profile['city']), @endif
                    {{ @$profile['country'] }}
                </div>
            </div>

            <div class="key-value">
                <div class="key">IPO date</div>
                <div class="value">{{ @$profile['ipo_date'] ?: '-' }}</div>
            </div>

            <div class="key-value">
                <div class="key">Number of Employees</div>
                <div class="value">{{ @$profile['employees'] ?: '-' }}</div>
            </div>

            <div class="key-value">
                <div class="key">Official Website</div>
                <div class="value">
                    @if (@$profile['website'])
                        <a target="_blank" href="{{ $profile['website'] }}">{{ getSiteNameFromUrl($profile['website']) }}</a>
                    @else
                        -
                    @endif
                </div>
            </div>

            @if($showFullProfile)
                <div class="key-value">
                    <div class="key">CIK</div>
                    <div class="value">{{ @$profile['cik'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">SIC Code</div>
                    <div class="value">{{ @$profile['sic_code'] ?: '-' }}</div>
                </div>


                <div class="key-value">
                    <div class="key">SIC Group</div>
                    <div class="value">{{ @$profile['sic_group'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">ISIN</div>
                    <div class="value">{{ @$profile['isin'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">Phone Number</div>
                    <div class="value">{{ @$profile['phone_number'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">LEI</div>
                    <div class="value">{{ @$profile['lei'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">Postal Code</div>
                    <div class="value">{{ @$profile['postal_code'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">Exchange</div>
                    <div class="value">{{ @$profile['exchange'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">Sec Filings URL</div>
                    <div class="value">
                        @if (@@$profile['sec_filings_url'])
                            <a target="_blank" href="{{ @$profile['sec_filings_url'] }}">{{ getSiteNameFromUrl(@$profile['sec_filings_url']) }}</a>
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div class="key-value">
                    <div class="key">One Year Beta</div>
                    <div class="value">{{ @$profile['one_year_beta'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">Three Year Beta</div>
                    <div class="value">{{ @$profile['three_year_beta'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">Five Year Beta</div>
                    <div class="value">{{ @$profile['five_year_beta'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">Seven Year Beta</div>
                    <div class="value">{{ @$profile['seven_year_beta'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">Ten Year Beta</div>
                    <div class="value">{{ @$profile['ten_year_beta'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">52 Week Range</div>
                    <div class="value">{{ @$profile['fiftytwo_week_range'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">Is Active</div>
                    <div class="value">{{ @$profile['is_active'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">Asset Type</div>
                    <div class="value">{{ @$profile['asset_type'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">Open FIGI Composite</div>
                    <div class="value">{{ @$profile['open_figi_composite'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">Price Currency</div>
                    <div class="value">{{ @$profile['price_currency'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">Market Sector</div>
                    <div class="value">{{ @$profile['market_sector'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">Security Type</div>
                    <div class="value">{{ @$profile['security_type'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">Is Fund</div>
                    <div class="value">{{ @$profile['is_fund'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">ETF</div>
                    <div class="value">{{ @$profile['is_etf'] ?: '-' }}</div>
                </div>

                <div class="key-value">
                    <div class="key">ADR</div>
                    <div class="value">{{ @$profile['is_adr'] ?: '-' }}</div>
                </div>
            @endif
        </div>
    </div>

    <div class="white-card">
        <div class="title">
            <div>Business Description</div>
        </div>
        <div class="text">
            {{ @$profile['description'] ?: 'Description not found' }}
        </div>
    </div>
</div>

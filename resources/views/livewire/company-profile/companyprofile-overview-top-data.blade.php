<div class="cards-wrapper ">
    <div class="white-card market-card-holder">
        <div class="title">Market Data</div>
        <div class="key-values-wrapper">

            <div class="key-value">
                <div class="key">52 Week High</div>
                <div class="value">{{ getLowPriceFromDashRange(@$profile['fiftytwo_week_range']) ?: '-' }}</div>
            </div>
            <div class="key-value">
                <div class="key">52 Week Low</div>
                <div class="value">{{ getHighPriceFromDashRange($profile['fiftytwo_week_range']) ?: '-' }}</div>
            </div>

            <div class="key-value">
                <div class="key">Avg. 3mths Vol.</div>
                <div class="value">31.54MM</div>
            </div>

            <div class="key-value">
                <div class="key">Beta</div>
                <div class="value">1.06</div>
            </div>

            <div class="key-value">
                <div class="key">Short Interest</div>
                <div class="value">0.4%</div>
            </div>
        </div>
    </div>

    <div class="white-card market-card-holder ">
        <div class="title">Capital Structure</div>
        <div class="key-values-wrapper">

            <div class="key-value">
                <div class="key">Market Capital</div>
                <div class="value">$133.74</div>
            </div>
            <div class="key-value">
                <div class="key">Total Enterprise Value</div>
                <div class="value">$83.34</div>
            </div>

            <div class="key-value">
                <div class="key">Shares Outstanding</div>
                <div class="value">31.54MM</div>
            </div>

            <div class="key-value">
                <div class="key">LTM Net Debt</div>
                <div class="value">1.06</div>
            </div>

            <div class="key-value">
                <div class="key">LTM Net Debt/EBITDA</div>
                <div class="value">0.4%</div>
            </div>
        </div>
    </div>

    <div class="white-card market-card-holder ">
        <div class="title">Profitability</div>
        <div class="key-values-wrapper">
            <div class="key-value">
                <div class="key">Gross Margin</div>
                <div class="value">$133.74</div>
            </div>
            <div class="key-value">
                <div class="key">EBIT Margin</div>
                <div class="value">$83.34</div>
            </div>

            <div class="key-value">
                <div class="key">ROA</div>
                <div class="value">31.54MM</div>
            </div>

            <div class="key-value">
                <div class="key">ROE</div>
                <div class="value">1.06</div>
            </div>

            <div class="key-value">
                <div class="key">ROIC</div>
                <div class="value">0.4%</div>
            </div>
        </div>
    </div>

    <div class="white-card market-card-holder ">
        <div class="title">LTM Valuation</div>
        <div class="key-values-wrapper">
            <div class="key-value">
                <div class="key">EV/Revenues</div>
                <div class="value">$133.74</div>
            </div>
            <div class="key-value">
                <div class="key">LTM EV/Gross Profit</div>
                <div class="value">$83.34</div>
            </div>

            <div class="key-value">
                <div class="key">LTM EV/Adj. EBIT</div>
                <div class="value">31.54MM</div>
            </div>

            <div class="key-value">
                <div class="key">LTM EV/Adj. P/E</div>
                <div class="value">1.06</div>
            </div>

            <div class="key-value">
                <div class="key">LTM P/BV</div>
                <div class="value">0.4%</div>
            </div>
        </div>
    </div>
</div>

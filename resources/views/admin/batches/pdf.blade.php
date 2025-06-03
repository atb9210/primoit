<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batch {{ $batch->reference_code }} - {{ $batch->name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 10px;
        }
        .header {
            padding: 20px 20px 10px;
            border-bottom: 1px solid #eaeaea;
            margin-bottom: 20px;
        }
        .company-info {
            float: left;
        }
        .batch-info {
            float: right;
            text-align: right;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #1a2a36;
            margin: 0;
        }
        .company-details {
            font-size: 11px;
            color: #666;
        }
        .batch-title {
            font-size: 18px;
            font-weight: bold;
            color: #1a2a36;
        }
        .batch-ref {
            font-size: 12px;
            color: #666;
        }
        .batch-status {
            margin-top: 5px;
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            text-transform: uppercase;
        }
        .status-active {
            background-color: #e6f4ea;
            color: #137333;
        }
        .status-reserved {
            background-color: #fef7e0;
            color: #b06000;
        }
        .status-sold {
            background-color: #e8f0fe;
            color: #1967d2;
        }
        .status-draft {
            background-color: #f1f3f4;
            color: #5f6368;
        }
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
        .summary-box {
            margin: 0 20px 20px;
            padding: 10px 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #eaeaea;
        }
        .summary-item {
            display: inline-block;
            margin-right: 30px;
        }
        .summary-label {
            font-size: 11px;
            color: #666;
            margin-bottom: 3px;
        }
        .summary-value {
            font-size: 14px;
            font-weight: bold;
            color: #1a2a36;
        }
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 20px;
            max-width: calc(100% - 40px);
        }
        .products-table th {
            background-color: #f1f3f4;
            padding: 4px 3px;
            text-align: center;
            font-size: 8px;
            color: #5f6368;
            text-transform: uppercase;
            border: 1px solid #eaeaea;
        }
        .products-table td {
            padding: 3px;
            font-size: 8px;
            border: 1px solid #eaeaea;
            vertical-align: top;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-align: center;
        }
        .price {
            text-align: right;
            font-weight: bold;
        }
        .quantity {
            text-align: center;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .page-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 10px 20px;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #eaeaea;
            text-align: center;
        }
        .product-type {
            display: inline-block;
            font-size: 8px;
            padding: 2px 5px;
            border-radius: 3px;
            background-color: #e8f0fe;
            color: #1967d2;
            text-transform: uppercase;
        }
        .grade {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 8px;
        }
        .grade-a {
            background-color: #e6f4ea;
            color: #137333;
        }
        .grade-b {
            background-color: #fef7e0;
            color: #b06000;
        }
        .grade-c {
            background-color: #fce8e6;
            color: #c5221f;
        }
        .product-model {
            font-weight: bold;
        }
        .specification-label {
            color: #5f6368;
            font-size: 8px;
        }
        .logo {
            height: 40px;
            margin-bottom: 5px;
        }
        .batch-date {
            font-size: 11px;
            color: #666;
            margin-top: 3px;
        }
        @page {
            margin: 40px 20px 30px;
        }
        body {
            margin-bottom: 0;
            padding-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="header clearfix">
        <div class="company-info">
            <img src="{{ public_path('img/logo.png') }}" alt="PrimoIT Logo" class="logo">
            <div class="company-name">PrimoIT</div>
            <div class="company-details">
                Wholesale IT Equipment<br>
                www.primoit.it<br>
                info@primoit.it
            </div>
        </div>
        <div class="batch-info">
            <div class="batch-title">{{ $batch->name }}</div>
            <div class="batch-ref">Ref: {{ $batch->reference_code }}</div>
            <div class="batch-date">
                Generated: {{ now()->format('d/m/Y H:i') }}<br>
                @if($batch->available_from)
                Available: {{ $batch->available_from->format('d/m/Y') }}
                @if($batch->available_until)
                 - {{ $batch->available_until->format('d/m/Y') }}
                @endif
                @endif
            </div>
            <div>
                <span class="batch-status status-{{ $batch->status }}">
                    {{ ucfirst($batch->status) }}
                </span>
            </div>
        </div>
    </div>

    <div class="summary-box clearfix">
        <div class="summary-item">
            <div class="summary-label">Category</div>
            <div class="summary-value">{{ $category->name ?? 'N/A' }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Producer</div>
            <div class="summary-value">{{ $batch->product_manufacturer }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Model</div>
            <div class="summary-value">{{ $batch->product_model }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Total Quantity</div>
            <div class="summary-value">{{ $totalQuantity }} units</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Total Price</div>
            <div class="summary-value">€{{ number_format($totalPrice, 2, ',', '.') }}</div>
        </div>
        @if($batch->condition_grade)
        <div class="summary-item">
            <div class="summary-label">Condition</div>
            <div class="summary-value">{{ $batch->condition_grade }}</div>
        </div>
        @endif
        @if($batch->visual_grade)
        <div class="summary-item">
            <div class="summary-label">Visual Grade</div>
            <div class="summary-value">{{ $batch->visual_grade }}</div>
        </div>
        @endif
    </div>

    @if($batch->description)
    <div style="margin: 0 20px 20px; font-size: 11px;">
        <strong>Description:</strong> {{ $batch->description }}
    </div>
    @endif

    @if(is_array($batch->products) && count($batch->products) > 0)
    <?php
    // Determiniamo quali colonne hanno valori
    $hasManufacturer = false;
    $hasModel = false;
    $hasGrade = false;
    $hasTechGrade = false;
    $hasCpu = false;
    $hasRam = false;
    $hasStorage = false;
    $hasScreen = false;
    $hasResolution = false;
    $hasOs = false;
    $hasColor = false;
    $hasBattery = false;
    $hasProblems = false;
    $hasNotes = false;
    $hasParameters = false;
    
    foreach ($batch->products as $product) {
        if (!empty($product['manufacturer'] ?? $batch->product_manufacturer)) $hasManufacturer = true;
        if (!empty($product['model'] ?? $batch->product_model)) $hasModel = true;
        if (!empty($product['grade'])) $hasGrade = true;
        if (!empty($product['tech_grade'])) $hasTechGrade = true;
        if (!empty($product['cpu'])) $hasCpu = true;
        if (!empty($product['ram'])) $hasRam = true;
        if (!empty($product['storage'])) $hasStorage = true;
        if (!empty($product['screen_size'])) $hasScreen = true;
        if (!empty($product['resolution'])) $hasResolution = true;
        if (!empty($product['operating_system'])) $hasOs = true;
        if (!empty($product['color'])) $hasColor = true;
        if (!empty($product['battery'])) $hasBattery = true;
        if (!empty($product['problems'])) $hasProblems = true;
        if (!empty($product['notes'])) $hasNotes = true;
        if (!empty($product['parameters']) && is_array($product['parameters']) && count($product['parameters']) > 0) $hasParameters = true;
    }
    
    $hasNotesOrProblems = $hasProblems || $hasNotes || $hasParameters;
    ?>
    <table class="products-table">
        <thead>
            <tr>
                <th style="width: 3%">ID</th>
                @if($hasManufacturer)<th style="width: 4%">Producer</th>@endif
                @if($hasModel)<th style="width: 5%">Model</th>@endif
                @if($hasGrade)<th style="width: 3%">Grade</th>@endif
                @if($hasTechGrade)<th style="width: 5%">Tech Grade</th>@endif
                <th style="width: 2%">Qty</th>
                <th style="width: 3%">Price</th>
                @if($hasCpu)<th style="width: 5%">CPU</th>@endif
                @if($hasRam)<th style="width: 2%">RAM</th>@endif
                @if($hasStorage)<th style="width: 5%">Storage</th>@endif
                @if($hasScreen)<th style="width: 4%; text-align: left;">Screen</th>@endif
                @if($hasResolution)<th style="width: 4%; text-align: left;">Res</th>@endif
                @if($hasOs)<th style="width: 4%">OS</th>@endif
                @if($hasColor)<th style="width: 3%">Color</th>@endif
                @if($hasBattery)<th style="width: 3%">Batt</th>@endif
                @if($hasNotesOrProblems)<th style="width: 18%">Problems/Notes</th>@endif
            </tr>
        </thead>
        <tbody>
            @foreach($batch->products as $index => $product)
            <tr @if($index % 2 == 0) style="background-color: #f9f9f9;" @endif>
                <td>{{ $product['id'] ?? '-' }}</td>
                @if($hasManufacturer)<td title="{{ $product['manufacturer'] ?? $batch->product_manufacturer }}">{{ substr($product['manufacturer'] ?? $batch->product_manufacturer, 0, 10) }}</td>@endif
                @if($hasModel)<td title="{{ $product['model'] ?? $batch->product_model }}">{{ substr($product['model'] ?? $batch->product_model, 0, 12) }}</td>@endif
                @if($hasGrade)
                <td>
                    @if(isset($product['grade']))
                    <span class="grade 
                        @if(strpos(strtolower($product['grade']), 'a') !== false) grade-a
                        @elseif(strpos(strtolower($product['grade']), 'b') !== false) grade-b
                        @elseif(strpos(strtolower($product['grade']), 'c') !== false) grade-c
                        @endif">
                        {{ $product['grade'] }}
                    </span>
                    @else
                    -
                    @endif
                </td>
                @endif
                @if($hasTechGrade)
                <td>
                    @if(isset($product['tech_grade']))
                    <span class="grade 
                        @if($product['tech_grade'] === 'Working') grade-a
                        @elseif($product['tech_grade'] === 'Working*') grade-b
                        @elseif($product['tech_grade'] === 'Not working') grade-c
                        @endif">
                        {{ $product['tech_grade'] }}
                    </span>
                    @else
                    -
                    @endif
                </td>
                @endif
                <td class="quantity">{{ $product['quantity'] ?? 1 }}</td>
                <td class="price">€{{ number_format((isset($product['price']) ? $product['price'] : 0) * (isset($product['quantity']) ? $product['quantity'] : 1), 2, ',', '.') }}</td>
                @if($hasCpu)<td title="{{ $product['cpu'] ?? '-' }}">{{ $product['cpu'] ?? '-' }}</td>@endif
                @if($hasRam)<td>{{ $product['ram'] ?? '-' }}</td>@endif
                @if($hasStorage)<td>{{ $product['storage'] ?? '-' }}</td>@endif
                @if($hasScreen)<td style="text-align: left;">{{ $product['screen_size'] ?? '-' }}</td>@endif
                @if($hasResolution)<td style="text-align: left;">{{ $product['resolution'] ?? '-' }}</td>@endif
                @if($hasOs)<td title="{{ $product['operating_system'] ?? '-' }}">{{ substr($product['operating_system'] ?? '-', 0, 8) }}</td>@endif
                @if($hasColor)<td>{{ $product['color'] ?? '-' }}</td>@endif
                @if($hasBattery)<td>{{ $product['battery'] ?? '-' }}</td>@endif
                @if($hasNotesOrProblems)
                <td style="white-space: normal; font-size: 7px;">
                    @if(isset($product['problems']) && !empty($product['problems']))
                    <div title="{{ $product['problems'] }}"><b>P:</b> {{ substr($product['problems'], 0, 30) }}{{ strlen($product['problems']) > 30 ? '...' : '' }}</div>
                    @endif
                    @if(isset($product['notes']) && !empty($product['notes']))
                    <div title="{{ $product['notes'] }}"><b>N:</b> {{ substr($product['notes'], 0, 30) }}{{ strlen($product['notes']) > 30 ? '...' : '' }}</div>
                    @endif
                    @if(isset($product['parameters']) && is_array($product['parameters']) && count($product['parameters']) > 0)
                        @foreach($product['parameters'] as $paramKey => $paramValue)
                            <div title="{{ $paramKey }}: {{ $paramValue }}"><b>{{ substr(ucfirst($paramKey), 0, 3) }}:</b> {{ substr($paramValue, 0, 15) }}{{ strlen($paramValue) > 15 ? '...' : '' }}</div>
                        @endforeach
                    @endif
                </td>
                @endif
            </tr>
            @endforeach
            <tr class="total-row">
                <?php
                $colSpan = 1; // ID column
                if ($hasManufacturer) $colSpan++;
                if ($hasModel) $colSpan++;
                if ($hasGrade) $colSpan++;
                if ($hasTechGrade) $colSpan++;
                ?>
                <td colspan="{{ $colSpan }}" style="text-align: right; padding-right: 10px;">TOTAL</td>
                <td class="quantity">{{ $totalQuantity }}</td>
                <td class="price">€{{ number_format($totalPrice, 2, ',', '.') }}</td>
                <?php
                $colSpan2 = 0;
                if ($hasCpu) $colSpan2++;
                if ($hasRam) $colSpan2++;
                if ($hasStorage) $colSpan2++;
                if ($hasScreen) $colSpan2++;
                if ($hasResolution) $colSpan2++;
                if ($hasOs) $colSpan2++;
                if ($hasColor) $colSpan2++;
                if ($hasBattery) $colSpan2++;
                if ($hasNotesOrProblems) $colSpan2++;
                ?>
                @if($colSpan2 > 0)<td colspan="{{ $colSpan2 }}"></td>@endif
            </tr>
        </tbody>
    </table>
    @else
    <div style="margin: 0 20px; padding: 20px; text-align: center; background-color: #f8f9fa; border-radius: 4px;">
        <p>No products available in this batch.</p>
    </div>
    @endif

    @if($batch->notes)
    <div style="margin: 20px; padding: 10px 15px; background-color: #f8f9fa; border-radius: 4px; border: 1px solid #eaeaea;">
        <strong>Notes:</strong><br>
        {{ $batch->notes }}
    </div>
    @endif
</body>
</html> 
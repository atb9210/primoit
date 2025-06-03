<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batch Label - {{ $batch->reference_code }}</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            width: 4in; /* 4 inches */
            height: 6in; /* 6 inches */
            margin: 0 auto;
            padding: 0.25in;
            border: 1px dashed #ccc;
        }
        
        @media print {
            body {
                border: none;
                padding: 0.125in;
                width: 100%;
                height: 100%;
            }
        }
        
        .label-container {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .header {
            text-align: center;
            margin-bottom: 0.2in;
            border-bottom: 1px solid #000;
            padding-bottom: 0.1in;
        }
        
        .company-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .batch-title {
            font-size: 18px;
            font-weight: bold;
            margin: 0.2in 0;
            text-align: center;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 35% 65%;
            gap: 8px;
            margin-bottom: 0.2in;
        }
        
        .info-label {
            font-weight: bold;
            font-size: 14px;
        }
        
        .info-value {
            text-align: left;
            font-size: 14px;
        }
        
        .qr-container {
            text-align: center;
            margin-top: auto;
            margin-bottom: 0.2in;
        }
        
        .qr-code {
            width: 2in;
            height: 2in;
            margin: 0 auto;
        }
        
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: auto;
            padding-top: 0.1in;
            border-top: 1px solid #000;
        }

        @media print {
            .print-button {
                display: none;
            }
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button">Print Label</button>
    
    <div class="label-container">
        <div class="header">
            <div class="company-name">PRIMO IT</div>
            <div>{{ config('app.url') }}</div>
        </div>
        
        <div class="batch-title">{{ $batch->name }}</div>
        
        <div class="info-grid">
            <div class="info-label">Ref. Code:</div>
            <div class="info-value">{{ $batch->reference_code }}</div>
            
            <div class="info-label">Quantity:</div>
            <div class="info-value">{{ $batch->unit_quantity }} units</div>
        </div>
        
        <div class="qr-container">
            <div class="qr-code">
                {!! QrCode::size(200)->generate(route('admin.batches.show', $batch)) !!}
            </div>
            <div style="margin-top: 5px;">Scan for details</div>
        </div>
        
        <div class="footer">
            <div>Printed on: {{ now()->format('d/m/Y H:i') }}</div>
        </div>
    </div>
</body>
</html> 
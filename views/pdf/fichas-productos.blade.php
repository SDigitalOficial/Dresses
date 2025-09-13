<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
    @page { margin: 20px; }
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
        color: #000;
    }
    .page {
        display: grid;
        grid-template-columns: 50% 50%;
        grid-template-rows: 50% 50%;
        gap: 10px;
        width: 100%;
        height: 100%;
        page-break-after: always;
    }
    .ficha {
        border: 1px solid #000;
        padding: 10px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        font-size: 12px;
    }
    .field {
        margin-bottom: 4px;
    }
    .label {
        display: inline-block;
        width: 80px;
    }
    .balance-label {
        color: red;
        font-weight: bold;
    }
    .disclaimer {
        font-size: 9px;
        margin-top: 8px;
        line-height: 1.2;
    }
    .signature {
        margin-top: 12px;
    }
    .signature-line {
        border-top: 1px solid #000;
        margin-top: 20px;
        width: 70%;
    }
</style>
</head>
<body>

@php
    $chunks = $products->chunk(4);
@endphp

@foreach($chunks as $chunk)
<div class="page">
    @foreach($chunk as $p)
        <div class="ficha">
            <div>
                <div class="field"><span class="label">Contact:</span> {{ $p->order->cliente->nombre ?? '—' }}</div>
                <div class="field"><span class="label">Event Date:</span> {{ $p->fecha_evento ?? '—' }}</div>
                <div class="field"><span class="label">Phone:</span> {{ $p->telefono ?? '—' }}</div>

                <div class="field"><span class="label">Color:</span> {{ $p->color ?? '—' }}</div>
                <div class="field"><span class="label">Size:</span> {{ $p->talla ?? '—' }}</div>
                <div class="field"><span class="balance-label">Balance Due:</span> ${{ number_format($p->precio ?? 0, 2) }}</div>
               
            </div>

            <div class="disclaimer">
               I have thoroughly inspected the merchandise listed above and I am accepting it in its current condition. I agree that after signing this I am responsible for any damage or flaws in this merchandise outside of the store. I further understand that there are no warranties on the purchase of this products/items and that I'm fully responsible of anything that can happen to it outside of the store. We do not accept any refunds or exchanges after an item has been deliver and taken out from the store. The Merchandise being picked up/delivered does not include a warranty, either expressed or implied.
            </div>

            <div class="signature">
                <div>Signature:</div>
                <div class="signature-line"></div>
                <div>Date:</div>
                <div class="signature-line"></div>
            </div>
        </div>
    @endforeach

    {{-- Rellenar con fichas vacías si hay menos de 4 --}}
    @for($i = $chunk->count(); $i < 4; $i++)
        <div class="ficha"></div>
    @endfor
</div>
@endforeach

</body>
</html>


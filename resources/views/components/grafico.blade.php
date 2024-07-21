@props([
    'title' => 'Gráfica de barras',
    'yAxisLabel' => 'Valor',
    'xAxisLabel' => 'Categorías',
    'data' => [],
    'colors' => ['#3498db', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6', '#1abc9c', '#d35400', '#34495e', '#7f8c8d'],
    'width' => '100%',
    'height' => '300px',
])

@php
    $maxValue = max(array_column($data, 'value'));
@endphp

<div class="chart-container" x-data="{
    chartData: @js($data),
    colors: @js($colors),
    maxValue: {{ $maxValue }},
    hoveredIndex: null,
    getHeight(value) {
        return (value / this.maxValue) * 100;
    }
}" x-cloak>
    <h2 class="chart-title">{{ $title }}</h2>
    <div class="chart" style="width: {{ $width }}; height: {{ $height }};">
        <div class="y-axis">
            @for ($i = 5; $i >= 0; $i--)
                <div class="tick">{{ round(($maxValue * $i) / 5) }}</div>
            @endfor
        </div>
        <div class="chart-area">
            <template x-for="(item, index) in chartData" :key="index">
                <div class="bar-column">
                    <div class="bar-wrapper">
                        <div class="bar"
                            :style="`height: ${getHeight(item.value)}%; background-color: ${colors[index]};`"
                            @mouseenter="hoveredIndex = index" @mouseleave="hoveredIndex = null">
                            <div class="bar-tooltip" x-show="hoveredIndex === index" x-transition>
                                <span x-text="item.name"></span>
                                <span x-text="item.value"></span>
                            </div>
                        </div>
                    </div>
                    <div class="x-axis-label" x-text="item.name"></div>
                </div>
            </template>
        </div>
    </div>
    <div class="legend">
        <template x-for="(item, index) in chartData" :key="index">
            <div class="legend-item">
                <span class="color-box" :style="`background-color: ${colors[index]};`"></span>
                <span x-text="item.name"></span>
            </div>
        </template>
    </div>
    <div class="axis-label y-label">{{ $yAxisLabel }}</div>
    <div class="axis-label x-label">{{ $xAxisLabel }}</div>
</div>

@push('styles')
    <style>
        .chart-container {
            font-family: 'Roboto', sans-serif;
            position: relative;
            padding: 2.5rem 1.5rem;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            overflow-x: auto;
            margin: 2rem 0;
        }

        .chart-title {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: clamp(1.2rem, 3vw, 1.8rem);
            color: #2c3e50;
            font-weight: 700;
        }

        .chart {
            display: flex;
            border-left: 2px solid #ecf0f1;
            border-bottom: 2px solid #ecf0f1;
            position: relative;
        }

        .y-axis {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding-right: 1rem;
            color: #7f8c8d;
            font-size: clamp(0.75rem, 2vw, 0.9rem);
        }

        .chart-area {
            display: flex;
            align-items: flex-end;
            height: 100%;
            padding-left: 1rem;
        }

        .bar-column {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-grow: 1;
            height: 100%;
            padding: 0 0.1rem;
            /* Reduced padding to bring bars closer */
        }

        .bar-wrapper {
            height: calc(100% - 2rem);
            width: 100%;
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }

        .bar {
            width: clamp(0.8rem, 2vw, 1.5rem);
            /* Reduced width for thinner bars */
            transition: all 0.3s ease;
            position: relative;
            border-radius: 3px 3px 0 0;
            /* Adjusted border-radius for thinner bars */
        }

        .bar:hover {
            transform: scaleY(1.05);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .bar-tooltip {
            position: absolute;
            top: -3.5rem;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(44, 62, 80, 0.9);
            color: white;
            padding: 0.6rem;
            border-radius: 6px;
            font-size: clamp(0.7rem, 2vw, 0.85rem);
            white-space: nowrap;
            pointer-events: none;
            z-index: 10;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .bar-tooltip span {
            display: block;
            text-align: center;
        }

        .x-axis-label {
            margin-top: 0.5rem;
            font-size: clamp(0.6rem, 1.5vw, 0.75rem);
            /* Reduced font size */
            color: #34495e;
            transform: rotate(-45deg);
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            max-width: 80px;
            /* Reduced max-width */
        }

        .legend {
            display: flex;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin: 0.5rem;
            font-size: clamp(0.75rem, 2vw, 0.9rem);
            color: #34495e;
        }

        .color-box {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
            border-radius: 3px;
        }

        .axis-label {
            position: absolute;
            font-weight: 600;
            color: #2c3e50;
            font-size: clamp(0.9rem, 2.5vw, 1.1rem);
        }

        .y-label {
            transform: rotate(-90deg);
            left: -3rem;
            top: 50%;
        }

        .x-label {
            bottom: -3rem;
            left: 50%;
            transform: translateX(-50%);
        }

        @media (max-width: 768px) {
            .chart-container {
                padding: 1.5rem 1rem;
            }

            .chart {
                height: 400px;
            }

            .y-axis {
                padding-right: 0.5rem;
            }

            .bar-tooltip {
                font-size: 0.7rem;
            }

            .legend {
                margin-top: 1.5rem;
            }

            .axis-label {
                font-size: 0.9rem;
            }

            .y-label {
                left: -2rem;
            }

            .x-label {
                bottom: -2.5rem;
            }
        }
    </style>
@endpush

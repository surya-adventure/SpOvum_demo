<!DOCTYPE html>
<html>

<head>
    <title>D3.js MySQL Data Visualizations</title>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <style>
        /* General Layout */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f8;
            color: #333;
            margin: 0;
            padding: 30px;
            line-height: 1.6;
        }

        h2 {
            color: #2c3e50;
            border-left: 5px solid #3498db;
            padding-left: 12px;
            margin-top: 50px;
            font-weight: 600;
        }

        /* Chart Container Styling */
        #colA_vs_sno,
        #colB_vs_sno,
        #avg_colA_vs_date,
        #avg_colB_vs_date {
            background: #ffffff;
            border: 1px solid #dfe6e9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            padding: 10px;
            margin-bottom: 40px;
            border-radius: 8px;
        }

        /* SVG Styling */
        svg {
            width: 100%;
            max-width: 800px;
            height: auto;
            border-radius: 4px;
            margin-left: 25%;
            margin-top: 7%;
        }

        /* Axis Text */
        .axis path,
        .axis line {
            fill: none;
            stroke: #ccc;
            shape-rendering: crispEdges;
        }

        text {
            font-size: 12px;
            fill: #555;
        }

        /* Line Stroke Colors */
        path {
            transition: all 0.3s ease-in-out;
        }

        path:hover {
            stroke-width: 3;
        }

        /* Responsive */
        @media screen and (max-width: 768px) {
            body {
                padding: 15px;
            }

            svg {
                width: 100%;
                height: auto;
            }
        }


        svg {
            margin-bottom: 60px;
        }
    </style>
</head>

<body>

    <center>
        <h1>PHP & D3.JS</h1>
    </center>

    <h2>colA vs Sno</h2>
    <div id="colA_vs_sno"></div>

    <h2>colB vs Sno</h2>
    <div id="colB_vs_sno"></div>

    <h2>Average colA vs Date</h2>
    <div id="avg_colA_vs_date"></div>

    <h2>Average colB vs Date</h2>
    <div id="avg_colB_vs_date"></div>

    <script>
        function drawLineChart(container, data, xKey, yKey, label) {
            const width = 600,
                height = 300,
                margin = 50;

            const svg = d3.select(container)
                .append("svg")
                .attr("width", width)
                .attr("height", height);

            const x = d3.scaleLinear()
                .domain(d3.extent(data, d => +d[xKey]))
                .range([margin, width - margin]);

            const y = d3.scaleLinear()
                .domain([0, d3.max(data, d => +d[yKey])])
                .range([height - margin, margin]);

            svg.append("g")
                .attr("transform", `translate(0,${height - margin})`)
                .call(d3.axisBottom(x));

            svg.append("g")
                .attr("transform", `translate(${margin},0)`)
                .call(d3.axisLeft(y));

            const line = d3.line()
                .x(d => x(+d[xKey]))
                .y(d => y(+d[yKey]));

            svg.append("path")
                .datum(data)
                .attr("fill", "none")
                .attr("stroke", "steelblue")
                .attr("stroke-width", 2)
                .attr("d", line);
        }

        function drawDateChart(container, data, yKey) {
            const width = 600,
                height = 300,
                margin = 50;

            const parseDate = d3.timeParse("%Y-%m-%d");
            data.forEach(d => d.date = parseDate(d.date));

            const x = d3.scaleTime()
                .domain(d3.extent(data, d => d.date))
                .range([margin, width - margin]);

            const y = d3.scaleLinear()
                .domain([0, d3.max(data, d => +d[yKey])])
                .range([height - margin, margin]);

            const svg = d3.select(container)
                .append("svg")
                .attr("width", width)
                .attr("height", height);

            svg.append("g")
                .attr("transform", `translate(0,${height - margin})`)
                .call(d3.axisBottom(x));

            svg.append("g")
                .attr("transform", `translate(${margin},0)`)
                .call(d3.axisLeft(y));

            const line = d3.line()
                .x(d => x(d.date))
                .y(d => y(+d[yKey]));

            svg.append("path")
                .datum(data)
                .attr("fill", "none")
                .attr("stroke", "tomato")
                .attr("stroke-width", 2)
                .attr("d", line);
        }

        async function init() {
            const colAData = await fetch("data.php?mode=sno_colA").then(res => res.json());
            drawLineChart("#colA_vs_sno", colAData, "Sno", "colA", "colA vs Sno");

            const colBData = await fetch("data.php?mode=sno_colB").then(res => res.json());
            drawLineChart("#colB_vs_sno", colBData, "Sno", "colB", "colB vs Sno");

            const avgAData = await fetch("data.php?mode=avg_colA").then(res => res.json());
            drawDateChart("#avg_colA_vs_date", avgAData, "avg_colA");

            const avgBData = await fetch("data.php?mode=avg_colB").then(res => res.json());
            drawDateChart("#avg_colB_vs_date", avgBData, "avg_colB");
        }

        init();
    </script>
</body>

</html>
<h1>Reporte de Ingresos</h1>

<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Monto</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ingresos as $ingreso)
            <tr>
                <td>{{ $ingreso->fecha }}</td>
                <td>{{ $ingreso->monto }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@if(isset($analyticsData))
<x-control-panel-layout>
    <div class="control-panel-card">
        <h2 class="control-panel-title">Homepage Stats (Last 7 Days)</h2>
        <table class="table-auto w-full mt-4">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Visitors</th>
                    <th>Page Views</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($analyticsData as $row)
                    <tr>
                        <td>{{ $row['date'] }}</td>
                        <td>{{ $row['visitors'] }}</td>
                        <td>{{ $row['pageViews'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-control-panel-layout>
@endif

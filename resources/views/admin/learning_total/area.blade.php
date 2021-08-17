<div id="levels_{{$level_code}}" class="collapse">
    <table class="table table-striped mb-0">
        <tbody>
            @foreach($summary['areas'] as $area)
            <tr>
                <td style="width: 20%"></td>
                <td style="width: 20%">{{$area->area_name}}</td>
                <td style="width: 40%">学習状況</td>
                <td style="width: 20%">{{($summary['result'] === 2 ? '修了' : $summary['result'] === 1) ? '学習中' : '未着手'}}</td>
            </tr>
            <tr>
                <td style="width: 20%"></td>
                <td style="width: 20%"></td>
                <td style="width: 40%">エリアキューブづくり</td>
                <td style="width: 20%">{{($area->area_practice_result === 2 ? '修了' : $area->area_practice_result === 1) ? '学習中' : '未着手'}}</td>
            </tr>
            <tr>
                <td style="width: 20%"></td>
                <td style="width: 20%"></td>
                <td style="width: 40%">エリアたつじんテスト</td>
                <td style="width: 20%">{{($area->area_test_result === 2 ? '修了' : $area->area_test_result === 1) ? '学習中' : '未着手'}}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
            <tr>
            @endforeach
            <tr>
                <td style="width: 20%"></td>
                <td style="width: 20%">マスタテスト</td>
                <td style="width: 40%"></td>
                <td style="width: 20%">@if ($summary["number_of_questions"]) {{$summary["number_of_corrects"] ?? 0}}/{{$summary["number_of_questions"]}} @endif</td>
            <tr>
        </tbody>
    </table>
</div>


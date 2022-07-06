@extends('layout')
@section('main')

    <div class="widget-body">
        <div class="widget-main padding-12 no-padding-left no-padding-right">
            <div class="tab-content padding-4">
                <div id="home2" class="tab-pane active">
                    @include('message')

                    <div class="row">
                        <div class="col-xs-12">

                            <div>
                                <div id="dynamic-table_wrapper" class="dataTables_wrapper form-inline no-footer">
                                    <!-- PAGE CONTENT BEGINS -->


                                        <!-- FILTERS -->
                                        <div class="row">
                                            <form method="POST" action="{{route('index')}}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-xs-2" style="width: 170px;">
                                                        <div>
                                                            <label>Тариф:
                                                                <input style="width: 60px;" type="text" autocomplete="off" name="tariff" value="{{isset($filters['tariff']) ? $filters['tariff'] : old('tariff') }}" class="form-control input-sm spinner">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-2" style="width: 210px;">
                                                        <div>
                                                            <label>Потребление:
                                                                <input style="width: 60px;" type="text" autocomplete="off" name="consumption" value="{{isset($filters['consumption']) ? $filters['consumption'] : old('consumption') }}" class="form-control input-sm spinner">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3" style="width: 370px;">
                                                        <div>
                                                            <label>Дата начала расчета:
                                                                <div class="input-group">
                                                                    <input class="form-control date-picker"  autocomplete="off" type="text"  name="date-start" value="{{isset($filters['date-start']) ? $filters['date-start'] : old('date-start') }}" data-date-format="yyyy-mm-dd">
                                                                    <span class="input-group-addon">
																		<i class="fa fa-calendar bigger-110"></i>
																	</span>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3" style="width: 395px;">
                                                        <div>
                                                            <label>Дата окончания расчета:
                                                                <div class="input-group">
                                                                    <input class="form-control date-picker" autocomplete="off" type="text"  name="date-finish" value="{{isset($filters['date-finish']) ? $filters['date-finish'] : old('date-finish')}}" data-date-format="yyyy-mm-dd">
                                                                    <span class="input-group-addon">
																		<i class="fa fa-calendar bigger-110"></i>
																	</span>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-1">
                                                        <div>
                                                            <div class="dataTables_length">
                                                                <button class="btn btn-info btn-xs" type="submit">
                                                                    Вперед
                                                                    <i class="ace-icon glyphicon glyphicon-search  align-top bigger-125 icon-on-right"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        @if($workers)
                                        <h3>Клиент: Вася Пупкин</h3>
                                        <h5>Worker: майнер</h5>

                                        <table id="simple-table" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr style="background-color: #6FB3E0!important; color: white">
                                                    <th>Воркер</th>
                                                    <th>Итого</th>
                                                    @foreach($dates as $date)
                                                        <th colspan="2" class="center">{{$date}}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($workers as $item)
                                                <tr class="ace-thumbnails">
                                                    <td>{{$item['worker_name']}}</td>
                                                    <td>{{$item['sum']}} руб.</td>
                                                    @foreach($dates as $date)

                                                            @foreach($item['dates'] as $date_w => $hashrate)
                                                            @if($date == $date_w)
                                                                <td>{{$hashrate['hashrate']}}  Th/s</td>
                                                                <td>{{$hashrate['amount']}}  руб.</td>
                                                            @endif
                                                            @endforeach

                                                    @endforeach
                                                </tr>
                                                <tr class="ace-thumbnails">
                                                    <td colspan="{{2 + count($dates) * 2}}" style="text-align: left;">
                                                        <b>Итого:</b> {{$item['sum']}} руб.
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <tr class="ace-thumbnails">
                                                    <td colspan="{{2 + count($dates) * 2}}" style="text-align: left;">
                                                        <b>Общий итог:</b> {{$sum}} руб.
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>

                                        <form method="POST" action="{{route('export')}}">
                                            @csrf
                                            <input type="hidden" name="tariff" value="{{isset($filters['tariff']) ? $filters['tariff'] : '' }}" >
                                            <input type="hidden" name="consumption" value="{{isset($filters['consumption']) ? $filters['consumption'] : '' }}">
                                            <input type="hidden" name="date-start" value="{{isset($filters['date-start']) ? $filters['date-start'] : '' }}">
                                            <input type="hidden" name="date-finish" value="{{isset($filters['date-finish']) ? $filters['date-finish'] : '' }}">

                                            <div>
                                                <div class="col-xs-2">
                                                    <div class="dataTables_length">
                                                        <button class="btn btn-success btn-xs" type="submit">
                                                            Выгрузить в Excel
                                                            <i class="ace-icon glyphicon glyphicon-list  align-top bigger-125 icon-on-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        @endif

                                </div>
                            </div>

                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(function($) {
            $('.spinner').ace_spinner({value:0,min:0,max:200,step:0.1, btn_up_class:'btn-info' , btn_down_class:'btn-info'});
            $('.date-picker').datepicker({
                autoclose: true,
                todayHighlight: true
            });

        });




    </script>
@stop

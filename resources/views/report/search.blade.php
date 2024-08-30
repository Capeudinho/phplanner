<form method="POST" action="{{route("report.generate")}}">
    @csrf
    <div class="row" style="margin-bottom: 10px">
        <div class="col-md-1" style="padding-right: 0px;padding-left: 0px">
            <label for="data">Data Inicial:</label><br>
        </div>
        <div class="col-md-2">
            <input type="date" name="start_date"
                class="form-control @error('start_date') is-invalid @enderror"
                @if(isset($start_date))value="{{$start_date}}"@else value="{{old("start_date")}}" @endif>
            @error('start_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-md-1" style="padding-right: 0px;padding-left: 0px">
            <label for="data">Data Final:</label><br>
        </div>
        <div class="col-md-2">
            <input type="date" name="end_date"
                   class="form-control @error('end_date') is-invalid @enderror"
                   @if(isset($end_date))value="{{$end_date}}"@else value="{{old("end_date")}}" @endif>
            @error('end_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="col-md-1">
            <label for="type">Relatório:</label><br>
        </div>
        <div class="col-md-4" style="padding-left: 0px">
            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                <option value="" disabled selected hidden>Selecione um Relatório</option>
                <option value="1" @if(isset($type) && $type==1) selected  @endif>Categorias de metas mais realizadas</option>
                <option value="2" @if(isset($type) && $type==2) selected  @endif>Categorias de tarefas mais realizadas</option>
                <option value="3" @if(isset($type) && $type==3) selected  @endif>Destacar turnos mais produtivos</option>
                <option value="4" @if(isset($type) && $type==4) selected  @endif>Quant. e Porcentagem de metas cumpridas</option>
                <option value="5" @if(isset($type) && $type==5) selected  @endif>Quant. e Porcentagem de tarefas executada</option>
                <option value="6" @if(isset($type) && $type==6) selected  @endif>Destacar semanas e meses mais produtivos</option>
            </select>
            @error('type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-md-1 justify-content-center">
            <button type="submit" class="btn btn-primary">Gerar</button>
        </div>
    </div>
</form>
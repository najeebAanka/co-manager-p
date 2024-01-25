<div class="form-row">
    <div class="col-md-12 mb-3">
        <label for="validationDefault02">
            <h6>{{ __('general.task_description') }}</h6>
        </label>
    </div>
    <div class="col-md-12 mb-3">
        <textarea id="task_description" class="form-control mb-2" placeholder="{{ __('general.task_description') }}" rows="5"><?= $data->description ?></textarea>
    </div>
    <div class="col-md-12 mb-3">
        <label for="validationDefault02">
            <h6>{{ __('general.duration_required') }}</h6>
        </label>
    </div>
    <div class="col-md-6 mb-3">
        <label for="validationDefault02">{{ __('general.hours') }}</label>
        <input type="number" id="duration_required_h" class="form-control mb-2" placeholder="{{ __('general.hours') }}"
            value="<?= floor($data->duration_required / 60) ?>" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="validationDefault02">{{ __('general.minutes') }}</label>

        <?php $c = $data->duration_required % 60; ?>
        <select id="duration_required_m" class="form-control">
            @for ($i = 0; $i <= 60; $i++)
                <option value="{{ $i }}" {{ $i == $c ? 'selected' : '' }}>{{ $i }}
                    {{ __('general.minutes') }}</option>
            @endfor

        </select>
    </div>
    {{-- <div class="col-md-12 mb-3">
        <label for="validationDefault02">
            <h6>{{ __('general.task_file') }}</h6>
        </label>
    </div>
    <div class="col-md-12 mb-3">
        <input type="file" id="task_file" class="form-control mb-2">
    </div> --}}

</div>
<button class="btn btn-primary" type="button"
    onclick="_saveTaskTiming({{ $data->id }} ,this)">{{ __('general.save_changes') }}</button>

@extends('layouts.app')
@section('style')
<!-- Necessary -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .text-align-end {
        text-align: end;
    }

    .alert-required {
        border-color: red;
        box-shadow: 0 0 0 0.25rem rgb(0 156 255 / 25%);
    }

</style>
@endsection
@section('content')
<div class="m-3">
    <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">Create Task</h6>
        <form action="{{ route('tasks.store') }}" method="POST" id="createTask">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInputName" name="name" placeholder="Task Name">
                        <label for="floatingInputName">Task Name</label>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelectUser" name="user_id" aria-label="Select User to Assign">
                            <option selected="">Select User</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelectUser">Select User to Assign Task</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 ">
                    <div class="form-floating mb-3">
                        <input type="text" readonly class="form-control" id="start" name="start" placeholder="Start Date Time" autocomplete="off">

                        <label for="start">Start Date Time</label>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <div class="form-floating mb-3">
                        <input type="text" readonly class="form-control" id="end" name="end" placeholder="End Date Time" autocomplete="off">

                        <label for="end">End Date Time</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="pro" name="priority" placeholder="Enter Priority" autocomplete="off">
                        <label for="pro">Enter Priority</label>
                    </div>
                </div>
                <div class="col-sm-8 text-align-end">
                    <button type="button" id="submitForm" class="btn btn-success m-2">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(function() {
        $('#start').datetimepicker({
            format: 'Y-m-d H:i'

        });
    });
    $(function() {
        $('#end').datetimepicker({
            format: 'Y-m-d H:i'

        });

    });
    $('input').on('input', function() {
        $(this).removeClass('alert-required');
    })
    $('select').on('change', function() {
        $(this).removeClass('alert-required');
    })
    $('input[name=start],input[name=end]').on('change', function() {
        $(this).removeClass('alert-required');
    })

    $('#submitForm').on('click', function() {
        if (jQuery.trim($('input[name=name]').val()) == '') {
            $('input[name=name]').addClass('alert-required');
        }
        if (jQuery.trim($('select[name=user_id]').val()) == '') {
            $('select[name=user_id]').addClass('alert-required');
        }
        if (jQuery.trim($('input[name=start]').val()) == '') {
            $('input[name=start]').addClass('alert-required');
        }
        if (jQuery.trim($('input[name=end]').val()) == '') {
            $('input[name=end]').addClass('alert-required');
        }
        if (jQuery.trim($('input[name=priority]').val()) == '') {
            $('input[name=priority]').addClass('alert-required');
        }
        if (jQuery.trim($('input[name=name]').val()) != '' &&
            jQuery.trim($('select[name=user_id]').val()) != '' &&
            jQuery.trim($('input[name=start]').val()) != '' &&
            jQuery.trim($('input[name=end]').val()) != '' &&
            jQuery.trim($('input[name=priority]').val()) != '') {
            console.log('sdaasd');
            $(this).prop('disabled', true);
            $('#createTask').submit();

        }

    })

</script>
@endsection

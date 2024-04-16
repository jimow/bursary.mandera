<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyStudentTransferRequest;
use App\Http\Requests\StoreStudentTransferRequest;
use App\Http\Requests\UpdateStudentTransferRequest;
use App\Models\Principal;
use App\Models\School;
use App\Models\Student;
use App\Models\StudentTransfer;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StudentTransfersController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('student_transfer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = StudentTransfer::with(['admission_number', 'trasnsfer_from', 'transfer_to', 'principal_approval_transfer_from', 'principal_approval_transfer_to', 'initiated_by', 'confirmed_by', 'authorized_by'])->select(sprintf('%s.*', (new StudentTransfer)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'student_transfer_show';
                $editGate      = 'student_transfer_edit';
                $deleteGate    = 'student_transfer_delete';
                $crudRoutePart = 'student-transfers';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('admission_number_admission_number', function ($row) {
                return $row->admission_number ? $row->admission_number->admission_number : '';
            });

            $table->editColumn('admission_number.nemis_number', function ($row) {
                return $row->admission_number ? (is_string($row->admission_number) ? $row->admission_number : $row->admission_number->nemis_number) : '';
            });
            $table->addColumn('trasnsfer_from_name', function ($row) {
                return $row->trasnsfer_from ? $row->trasnsfer_from->name : '';
            });

            $table->addColumn('transfer_to_name', function ($row) {
                return $row->transfer_to ? $row->transfer_to->name : '';
            });

            $table->addColumn('principal_approval_transfer_from_fullname', function ($row) {
                return $row->principal_approval_transfer_from ? $row->principal_approval_transfer_from->fullname : '';
            });

            $table->addColumn('principal_approval_transfer_to_fullname', function ($row) {
                return $row->principal_approval_transfer_to ? $row->principal_approval_transfer_to->fullname : '';
            });

            $table->addColumn('initiated_by_name', function ($row) {
                return $row->initiated_by ? $row->initiated_by->name : '';
            });

            $table->addColumn('confirmed_by_name', function ($row) {
                return $row->confirmed_by ? $row->confirmed_by->name : '';
            });

            $table->addColumn('authorized_by_name', function ($row) {
                return $row->authorized_by ? $row->authorized_by->name : '';
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? StudentTransfer::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'admission_number', 'trasnsfer_from', 'transfer_to', 'principal_approval_transfer_from', 'principal_approval_transfer_to', 'initiated_by', 'confirmed_by', 'authorized_by']);

            return $table->make(true);
        }

        $students   = Student::get();
        $schools    = School::get();
        $principals = Principal::get();
        $users      = User::get();

        return view('admin.studentTransfers.index', compact('students', 'schools', 'principals', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('student_transfer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admission_numbers = Student::pluck('admission_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $trasnsfer_froms = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $transfer_tos = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $confirmed_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.studentTransfers.create', compact('admission_numbers', 'confirmed_bies', 'transfer_tos', 'trasnsfer_froms'));
    }

    public function store(StoreStudentTransferRequest $request)
    {
        $studentTransfer = StudentTransfer::create($request->all());

        return redirect()->route('admin.student-transfers.index');
    }

    public function edit(StudentTransfer $studentTransfer)
    {
        abort_if(Gate::denies('student_transfer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admission_numbers = Student::pluck('admission_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $trasnsfer_froms = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $transfer_tos = School::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $confirmed_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $studentTransfer->load('admission_number', 'trasnsfer_from', 'transfer_to', 'principal_approval_transfer_from', 'principal_approval_transfer_to', 'initiated_by', 'confirmed_by', 'authorized_by');

        return view('admin.studentTransfers.edit', compact('admission_numbers', 'confirmed_bies', 'studentTransfer', 'transfer_tos', 'trasnsfer_froms'));
    }

    public function update(UpdateStudentTransferRequest $request, StudentTransfer $studentTransfer)
    {
        $studentTransfer->update($request->all());

        return redirect()->route('admin.student-transfers.index');
    }

    public function show(StudentTransfer $studentTransfer)
    {
        abort_if(Gate::denies('student_transfer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentTransfer->load('admission_number', 'trasnsfer_from', 'transfer_to', 'principal_approval_transfer_from', 'principal_approval_transfer_to', 'initiated_by', 'confirmed_by', 'authorized_by');

        return view('admin.studentTransfers.show', compact('studentTransfer'));
    }

    public function destroy(StudentTransfer $studentTransfer)
    {
        abort_if(Gate::denies('student_transfer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studentTransfer->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudentTransferRequest $request)
    {
        $studentTransfers = StudentTransfer::find(request('ids'));

        foreach ($studentTransfers as $studentTransfer) {
            $studentTransfer->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

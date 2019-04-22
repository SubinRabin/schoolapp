function studentTable() {
	$('#studentTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: 'TshowStudentlist',
                columns: [
                {data: 'rownum', name: 'rownum', "searchable": false},
                {data: 'studentId', name: 'studentId'},
                {data: 'Name', name: 'Name'},
                {data: 'ParentName', name: 'ParentName'},
                {data: 'Mobile', name: 'Mobile'},
                {data: 'classRoom', name: 'classRoom'},
                // {data: 'section', name: 'section'},
                {data: 'Program', name: 'Program'},
                {data: 'Therapy', name: 'Therapy'},
                {data: 'Status', name: 'Status'},
            ]
    });
}
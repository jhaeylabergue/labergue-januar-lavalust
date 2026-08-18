<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller
{
    /**
     * Sample student data passed to views.
     */
    private function getStudentData(): array
    {
        return [
            'student_id' => '2024-00265',
            'name'       => 'Januar Labergue',
            'course'     => 'BS Information Technology',
            'year'       => '3rd Year',
            'section'    => 'F2',
            'email'      => 'januarlabergue@gmail.com',
            'phone'      => '+63 994 598 8592',
            'address'    => 'Puerto Galera,Oriental Mindoro, Philippines',
            'skills'     => ['PHP', 'JavaScript', 'MySQL', 'LavaLust MVC'],
            'hobbies'    => ['Coding', 'Gaming', 'Watching movies'],
            'bio'        => 'Web Systems student building practical apps with the LavaLust PHP framework.',
        ];
    }

    public function index()
    {
        $this->call->library('session');

        if (isset($_GET['grant']) && $_GET['grant'] === '1') {
            $this->session->set_userdata('student_access', true);
        }

        $data['student']    = $this->getStudentData();
        $data['page_title']   = 'Januar Labergue — Student Portal';
        $data['active_page']  = 'home';
        $data['has_access']   = (bool) $this->session->userdata('student_access');

        $this->call->view('student/home', $data);
    }

    public function profile()
    {
        $data['student']   = $this->getStudentData();
        $data['page_title'] = 'Student Profile — Januar Labergue';
        $data['active_page'] = 'profile';

        $this->call->view('student/profile', $data);
    }
}

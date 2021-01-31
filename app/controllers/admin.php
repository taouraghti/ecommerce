<?php

class admin extends controller
{
    public function __construct()
    {
        $this->adminModel = $this->model('admins');
        $this->userModel = $this->model('users');
        $this->itemModel = $this->model('items');
        $this->catModel = $this->model('categories');
        $this->commentModel = $this->model('comments');
    }

    public function index()
    {
        if(isset($_SESSION['username']) && $_SESSION['group'] == 1)
            redirect('app/initadmin.php?url=admin/dashboard');
        else
        {
            $this->view('admin/login');
            $this->view('templates/footer');
        }
    }

    public function login()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $username = $_POST['user'];
            $pass = $_POST['pass'];
            $dataErr = [];
            $data = [];
            if(($loggedInAdmin = $this->adminModel->login($username, $pass)) != -1)
            {
                createSessionUser($loggedInAdmin);
                redirect('app/initadmin.php?url=admin/dashboard');
            }
                
            else
            {
                $dataErr[] = "Username or password incorrect";
                redirectError("/admin", $dataErr);
            }

        }
    }

    public function member()
    {
        if(isset($_SESSION['username']) && $_SESSION['group'] == 1)
        {
            $data = $this->userModel->getAll();
            $this->view('admin/navbar');
            $this->view("admin/member",$data);
        }
        else
            $this->view('admin/login');
        $this->view('templates/footer');
    }

    public function comment()
    {
        if(isset($_SESSION['username']) && $_SESSION['group'] == 1)
        {
            $data = $this->commentModel->getAll();
            $this->view('admin/navbar');
            $this->view("admin/comment",$data);
        }
        else
            $this->view('admin/login');
        $this->view('templates/footer');
    }

    public function item()
    {
        if(isset($_SESSION['username']) && $_SESSION['group'] == 1)
        {
            $data = $this->itemModel->getAll();
            $this->view('admin/navbar');
            $this->view("admin/item",$data);
        }
        else
            $this->view('admin/login');
        $this->view('templates/footer');
    }

    public function dashboard()
    {
        if(isset($_SESSION['username']) && $_SESSION['group'] == 1)
        {
            $data['countAllUser'] = $this->userModel->countAll();
            $data += ['countPendUser' => $this->userModel->countPend()];
            $data += ['LatestUser' => $this->userModel->getLatest()];
            $data += ['countItem' => $this->itemModel->countItem()];
            $data += ['LatestItem' => $this->itemModel->getLatest()];
            $data += ['countComment' => $this->commentModel->countComment()];
            $data += ['LatestComment' => $this->commentModel->getLatest()];
            $this->view('admin/navbar');
            $this->view('admin/dashboard',$data);
        }
        else
            $this->view('admin/login');
        $this->view('templates/footer');
    }

    public function categories()
    {
        if(isset($_SESSION['username']) && $_SESSION['group'] == 1)
        {
            $data = $this->catModel->getAll();
            $this->view('admin/navbar');
            $this->view('admin/categories',$data);
        }
        else
            $this->view('admin/login');
        $this->view('templates/footer');
    }

    public function addMember()
    {
        if(isset($_SESSION['username']) && $_SESSION['group'] == 1)
        {
            $this->view('admin/navbar');
            $this->view('admin/addMember');
        }
        else
            $this->view('admin/login');
        $this->view('templates/footer');
    }

    public function editMember($id)
    {
        if(isset($_SESSION['username']) && $_SESSION['group'] == 1)
        {
            $data = $this->userModel->getOne($id);
            $this->view('admin/navbar');
            $this->view('admin/editMember',$data);
        }
        else
            $this->view('admin/login');
        $this->view('templates/footer');
    }

    public function updateMember()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $avatar = $_FILES['avatar'];
            $avatarName = $avatar['name'];
            $avatarSize = $avatar['size'];
            $avatarTmp = $avatar['tmp_name'];
            $avatarType = $avatar['type'];

            // List Of Allowed File Types
            $avatarAllowedExtension = array('jpeg', 'jpg', 'png', 'gif');
            $avatarExtension = explode('.', $avatarName);
            $ext = strtolower(end($avatarExtension));

            $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : $pass = sha1($_POST['newpassword']);
            $dataErr = [];

            $data['fullname'] = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
            $data += ['id' =>  $_POST['userid']];
            $data += ['email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ];
            $data += ['username' => filter_var($_POST['username'], FILTER_SANITIZE_STRING) ];
            $data += ['password' => $pass ];

            if ($this->userModel->findUserByUsername($data['username'], $data['id']) == 1)
                $dataErr[] = "Username is already <strong>exist</strong>";
            if(empty($data['username']))
                $dataErr[] = "Username can't be <strong>Empty</strong>";
            if(empty($data['email']))
                $dataErr[] = "Email can't be <strong>Empty</strong>";
            if(empty($data['fullname']))
                $dataErr[] = "Full name can't be <strong>Empty</strong>";
            if (!empty($avatarName) &&!in_array($ext, $avatarAllowedExtension))
                $dataErr[] = "This Extension is Not <strong>Allowed</strong>";
            //Update The DataBase With This infos

            if (empty($dataErr))
            {
                if(empty($avatarName))
                {
                    $r = $this->userModel->getOne($data['id']);
                    $av = $r['Avatar'];
                }
                else
                {
                    $av = rand(0, 100000) . '_' . $avatarName;
                    move_uploaded_file($avatarTmp, "uploads\avatars\\" . $av);
                }
                $data += ['avatar' => $av];
                $this->userModel->update($data);
            }
                $this->view('admin/navbar');
                $this->view('admin/result',$dataErr);
        }
    }

    public function insertMember()
    {
        if(isset($_SESSION['username']) && $_SESSION['group'] == 1 && $_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $avatar = $_FILES['avatar'];
            $avatarName = $avatar['name'];
            $avatarSize = $avatar['size'];
            $avatarTmp = $avatar['tmp_name'];
            $avatarType = $avatar['type'];

            // List Of Allowed File Types
            $avatarAllowedExtension = array('jpeg', 'jpg', 'png', 'gif');
            $avatarExtension = explode('.', $avatarName);
            $ext = strtolower(end($avatarExtension));

            $dataErr = [];
            $data['fullname'] = filter_var($_POST['fullname'], FILTER_SANITIZE_STRING);
            $data['username'] = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $data += ['email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ];
            $data += ['username' => filter_var($_POST['username'], FILTER_SANITIZE_STRING) ];
            $data += ['password' => sha1($_POST['password']) ];
            if(empty($data['fullname']))
                $dataErr[] = "Full name can't be <strong>Empty</strong>";
            if(empty($data['password']))
                $dataErr[] = "Password can't be <strong>Empty</strong>";
            if(empty($data['email']))
                $dataErr[] = "Email can't be <strong>Empty</strong>";
            if(empty($data['username']))
                $dataErr[] = "Username can't be <strong>Empty</strong>";
            if ($this->userModel->findUserByUsername($data['username']) == 1)
                $dataErr[] = "Username is already <strong>exist</strong>";
            else
            {
                if ($this->userModel->findUserByUsername($data['username']) == 1)
                    $dataErr[] = "Username is already <strong>Taken</strong>";
            }
            if (!empty($avatarName) && !in_array($ext, $avatarAllowedExtension))
                $dataErr[] = "This extension is not <strong>Allowed</strong>";
            
            if(empty($dataErr))
            {
                if(empty($avatarName))
                    $avatarName = "inko.png";
                else
                {
                    $av = rand(0, 100000) . '_' . $avatarName;
                    move_uploaded_file($avatarTmp, "../uploads/avatars/" . $av);
                }
                $data += ["avatar" => $avatarName];
                $this->userModel->insert($data);
            }
            $this->view('admin/navbar');
            $this->view('admin/result',$dataErr);
        }
        else
            $this->view('admin/login');
        $this->view('templates/footer');
    }

    public function deleteMember($id)
    {
        if(isset($_SESSION['username']) && $_SESSION['group'] == 1)
        {
            $this->userModel->delete($id);
            redirect('app/initadmin.php?url=admin/member');
        }
        else
            $this->view('admin/login');
        $this->view('templates/footer');
    }

    public function addItem()
    {
        
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        redirect('app/initadmin.php?url=admin/index');
    }
}

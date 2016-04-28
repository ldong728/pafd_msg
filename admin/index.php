<?php

include_once '../includePackage.php';
include_once '../wechat/serveManager.php';
session_start();

if (isset($_SESSION['login'])) {

    if (isset($_GET['groupManager'])) {
        if (isset($_SESSION['pms']['group'])) {
            if (isset($_GET['groupList'])) {
                $slist = getGroupList();
                foreach ($slist as $row) {
                    if ($row['id'] == 1 || $row['id'] == 2) continue;//屏蔽星标组和黑名单
                    $list[] = $row;
                }
                if (!isset($list)) $list = array();
                printView('admin/view/groupManage.html.php', '分组管理');
                exit;
            }
        } else {
            echo '权限不足';
            exit;
        }

    }
    if (isset($_GET['noticeList'])) {
        if (isset($_SESSION['pms']['notice'])) {
            $where = null;
            $num = 15;
            $page = isset($_GET['page']) ? $_GET['page'] : 0;
            if (isset($_GET['situation'])) $where['situation'] = $_GET['source'];
            if (isset($_GET['group'])) $where['groupid'] = $_GET['group'];
            if (isset($_GET['category'])) $where['category'] = $_GET['category'];
            $notice = pdoQuery('notice_view', null, $where, ' order by create_time desc limit ' . $page * $num . ', ' . $num);
            printView('admin/view/notice.html.php', '通知列表');
            exit;

        } else {
            echo '权限不足';
            exit;
        }
    }
    if (isset($_GET['reviewList'])) {
        if (isset($_SESSION['pms']['notice'])) {
            $where['notice_id'] = $_GET['reviewList'];
            $num = 15;
            $page = isset($_GET['page']) ? $_GET['page'] : 0;
//            if(isset($_GET['situation']))$where['situation']=$_GET['source'];
//            if(isset($_GET['group']))$where['groupid']=$_GET['group'];
//            if(isset($_GET['category']))$where['category']=$_GET['category'];

            $reviewList = pdoQuery('review_view', null, $where, ' order by review_time desc limit ' . $page * $num . ', ' . $num);
            $reviewList = $reviewList->fetchAll();
            printView('admin/view/review.html.php', '留言列表');
            exit;

        } else {
            echo '权限不足';
            exit;
        }
    }
    if (isset($_GET['markList'])) {
        if (isset($_SESSION['pms']['notice'])) {
            $where['notice_id'] = $_GET['markList'];
            $num = 15;
            $page = isset($_GET['page']) ? $_GET['page'] : 0;
            $markList=pdoQuery('mark_view',null,$where, ' order by mark_time desc limit ' . $page * $num . ', ' . $num);
            printView('admin/view/mark.html.php', '已读列表');

            exit;
        } else {
            echo '权限不足';
            exit;
        }
    }
    if (isset($_GET['sendNotice'])) {
        if (isset($_SESSION['pms']['notice'])) {
            $readyQuery = pdoQuery('notice_tbl', null, array('situation' => '0'), null);
            foreach ($readyQuery as $row) {
                $ready[] = $row;
            }
            $groupList = getGroupList();
            foreach ($groupList as $row) {
                if ($row['id'] < 3) continue;//屏蔽星标组和黑名单
                $glist[] = $row;
            }
            printView('admin/view/sendNotice.html.php', '发送通知');
            exit;

        } else {
            echo '权限不足';
            exit;
        }

    }


    if (isset($_GET['newslist'])) {
        $cateQuery = pdoQuery('category_tbl', null, null, null);
        $cateList = $cateQuery->fetchAll();
        $where = null;
        $num = 15;
        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        if (isset($_GET['source'])) $where['source'] = $_GET['source'];
        if (isset($_GET['group'])) $where['groupid'] = $_GET['group'];
        if (isset($_GET['category'])) $where['category'] = $_GET['category'];
        $newsList = pdoQuery('news_tbl', null, $where, ' order by create_time desc limit ' . $page * $num . ', ' . $num);


        if (isset($_SESSION['pms']['news'])) {
//            echo getArrayInf($newsList);
            printView('admin/view/newslist.html.php', '图文列表');
            exit;
        } else {
            echo '权限不足';
            exit;
        }
    }
    if (isset($_GET['createNews'])) {
        if (isset($_SESSION['pms']['news'])) {
            printView('admin/view/createNews.html.php', '新建图文信息');
            exit;
        }
    }
    if (isset($_GET['userList'])) {
        if (isset($_SESSION['pms']['news'])) {
            $num = 15;
            $page = isset($_GET['page']) ? $_GET['page'] : 0;
            $index = $page * $num;
            $userquery = pdoQuery('user_tbl', null, null, " limit $page,$num");
            $userlist = $userquery->fetchAll();
            $groupList = getGroupList();
            foreach ($groupList as $row) {
                if ($row['id'] < 3) continue;//屏蔽星标组和黑名单
                $glist[] = $row;
            }
            printView('admin/view/user_list.html.php', '已关注列表');
            exit;
        } else {
            echo '权限不足';
            exit;
        }
    }

    if (isset($_GET['review'])) {
        if (isset($_SESSION['pms']['review'])) {
//            $limit = isset($_GET['index']) ? ' limit ' . $_GET['index'] . ', 20' : ' limit 20';
//            $reviewQuery = pdoQuery('review_tbl', null, array('priority' => '5', 'public' => '0'), $limit);
//            foreach ($reviewQuery as $row) {
//                $review[] = $row;
//            };
//            if (null == $review) $review = array();

            printView('admin/view/review.html.php', '评价管理');
            exit;
        } else {
            echo '权限不足';
            exit;
        }
    }
    if (isset($_GET['wechatConfig'])) {
        if (isset($_SESSION['pms']['wechat'])) {
            printView('admin/view/wechatConfig.html.php', '微信公众平台');
            exit;
        } else {
            echo '权限不足';
            exit;
        }
    }
    if (isset($_GET['index'])) {
        if (isset($_SESSION['pms']['index'])) {
            $config = getConfig('../mobile/config/config.json');
            $remarkQuery = pdoQuery('index_remark_tbl', null, null, null);
            $frontImg = pdoQuery('ad_tbl', null, array('category' => 'banner'), null);
            printView('admin/view/admin_index.html.php', '三北武装');
            exit;
        } else {
            echo '权限不足';
            exit;
        }
    }
    if (isset($_GET['category'])) {
        if (isset($_SESSION['pms']['index'])) {
            $cate = pdoQuery('category_view', null, null, null);
            printView('admin/view/category.html.php', '三北武装');
            exit;
        } else {
            echo '权限不足';
            exit;
        }
    }
    if (isset($_GET['operator'])) {
        if (isset($_SESSION['pms']['operator'])) {
            $query = pdoQuery('pms_tbl', null, null, null);
            foreach ($query as $row) {
                $pmsList[$row['key']] = array('value' => $row['key'], 'name' => $row['name']);
            }
            $query = pdoQuery('pms_view', null, null, null);
            foreach ($query as $row) {
                if (!isset($opList[$row['id']])) {
                    $opList[$row['id']] = array(
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'pwd' => $row['pwd'],
                        'pms' => $pmsList
                    );
//                    $opList[$row['id']]=$pmsList;
                }
                $opList[$row['id']]['pms'][$row['pms']]['checked'] = 'checked';
            }
//            mylog(getArrayInf($opList));
            printView('admin/view/operator.html.php', '操作员管理');
            exit;

        } else {
            echo '权限不足';
            exit;
        }
    }
    if (isset($_GET['logout'])) {//登出
        session_unset();
        include 'view/login.html.php';
        exit;
    }
    printView('admin/view/blank.html.php', '三北武装');
    exit;
} else {
    if (isset($_GET['login'])) {
        $name = $_POST['adminName'];
        $pwd = $_POST['password'];
        if ($_POST['adminName'] . $_POST['password'] == ADMIN . PASSWORD) {
            $_SESSION['login'] = 1;
            $_SESSION['operator_id'] = -1;
            $pms = pdoQuery('pms_tbl', null, null, null);
            foreach ($pms as $row) {
                $_SESSION['pms'][$row['key']] = 1;
            }
            printView('admin/view/blank.html.php', '三北武装');
        } else {
            $query = pdoQuery('operator_tbl', null, array('name' => $name, 'md5' => md5($pwd)), ' limit 1');
            $op_inf = $query->fetch();
            if (!$op_inf) {
                include 'view/login.html.php';
                exit;
            } else {
                $_SESSION['login'] = 1;
                $_SESSION['operator_id'] = $op_inf['id'];
                $pms = pdoQuery('op_pms_tbl', null, array('o_id' => $op_inf['id']), null);
                foreach ($pms as $row) {
                    $_SESSION['pms'][$row['pms']] = 1;
                }
                printView('admin/view/blank.html.php', '三北武装');
                exit;
            }

        }
        exit;
    }
    include 'view/login.html.php';
    exit;
}
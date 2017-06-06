#使用方法
1. 把整个文件夹放在 应用文件夹的Common文件夹下
2. 在DbVersion内编写数据库操作文件，具体参考V1.class.php文件
3. 写在以后，更新配置文件DbUpdateConfig内的数组:

~~~ php
1 => '\\Common\\Migration\\DbVersion\\V1'
~~~

1代表是版本号,\\Common\\Migration\\DbVersion\\V1 对应的是V1.class.php文件


4. 下面是在Controller触发数据库版本更新的例子

~~~ php
<?php
namespace Admin\Controller;
use Common\Migration\DbUpdate;
use Think\Controller;
/**
 * 后台管理通用模块
 */
class DemoController extends Controller
{
	/**
	 * 后台首页
	 */
	public function index()
	{
		$dbUpdate = new DbUpdate();
		$dbUpdate->update(M(''));
	}
}
~~~

TODO:
- [ ] 重新设计uml
- [ ] 重命名所有的.class.php 为php
- [ ] 根据新uml重新实现代码，同时用codeception写测试用例
- [ ] 有用户，还是想做一层sql封装，不想用原生的语句。。。这个要再考虑考虑
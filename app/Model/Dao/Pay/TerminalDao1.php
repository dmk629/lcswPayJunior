<?php declare(strict_types=1);
namespace App\Model\Dao\Pay;
use Swoft\Bean\Annotation\Mapping\Bean;
use App\Model\Entity\PayTerminal;
use Throwable;

/**
 * 终端数据访问类
 * @Bean(name="TerminalDao", scope=Bean::SINGLETON)
 *
 * @since 2.0
 */
class TerminalDao1
{
    /**
     * 创建终端
     * @var int $terminal_id
     * @var string $name
     * @var string $access_token
     *
     * @return void
     * @throws Throwable
     */
    public function addTerminal(int $terminal_id, string $name, string $access_token)
    {
        if(!$this->terminalExist()){
            PayTerminal::Insert([
                "id" => $terminal_id,
                "name" => $name,
                "access_token" => $access_token
            ]);
        }
    }

    /**
     * 获取终端信息
     *
     * @return array
     * @throws Throwable
     */
    public function getTerminal()
    {
        $info = PayTerminal::select("id","access_token")->first();
        return empty($info) ? [] : $info->toArray();
    }

    /**
     * 终端存在
     * @return bool
     * @throws Throwable
     * */
    private function terminalExist()
    {
        $exist_result = $this->getTerminal();
        if(empty($exist_result))return false;
        return true;
    }
}

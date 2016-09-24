<?php
/**
 * Description of PermissaoGrupo.
 *
 * @author edily
 */

//Somente Importação
class PermissaoGrupo extends Model
{
    protected $usuarioId;
    protected $table = 'permissao_grupo';
    protected $alias = 'bd1';
    protected $colsPass = array('id', 'nome', 'descricao');

    public function buscaControllers()
    {
        $c = 0;
        $dir = dir(APP_CONTROLLER_PATH);
        while (($arq = $dir->read()) != false) {
            $controllerNome = $this->pegaControllerNome($arq);
            $c += (int) $this->buscaGravaActions(APP_CONTROLLER_PATH.'/'.$arq, $controllerNome);
        }

        return $c;
    }

    public function buscaGravaActions($path, $controllerNome)
    {
        $c = 0;
        $conteudo = file_get_contents($path);
        $linhas = explode("\n", $conteudo);
        foreach ($linhas as $linha) {
            $actionNome = $this->pegaActionNome($linha);
            if (!empty($actionNome)) {
                $grupoNome = $controllerNome.'_'.$actionNome;
                if ($this->grupoExiste($grupoNome) === false) {
                    $this->insert(array('nome' => $grupoNome, 'descricao' => $grupoNome));
                    ++$c;
                }
            }
        }

        return $c;
    }

    public function pegaActionNome($linha)
    {
        $linha = str_replace('(', ' ', $linha);
        $linha = str_replace('>', ' ', $linha);

        $palavras = explode(' ', $linha);
        foreach ($palavras as $palavra) {
            if (strpos($palavra, 'Action') !== false) {
                $palavra = str_replace('Action', '', $palavra);

                return trim($palavra);
            }
        }
    }

    public function pegaControllerNome($linha)
    {
        return str_replace('Controller.php', '', $linha);
    }

    public function grupoExiste($nome)
    {
        return $this->findRow("nome = '{$nome}'") !== false ? true : false;
    }
}

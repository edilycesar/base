<?php
/**
 * Description of Servico.
 *
 * @author edily
 */
class Contato extends Model
{
    public function enviar($dados)
    {
        $email = new Email();
        $email->from = $dados['E-mail'];
        $email->fronName = $dados['Nome'];
        $email->confirmReadingTo = $dados['E-mail'];
        $email->message = $this->preparaMsg($dados);
        $email->subject = '*** Contato feito pelo Site *** ';
        $email->addAddress(EMAIL_MASTER);
        $email->addAddress(EMAIL2_MASTER);

        $email->addReplyTo($dados['E-mail']);

        if ($email->send()) {
            FlashMsg::setMsgOk('Mensagem enviada com sucesso, agradecemos o contato!', 1);

            return true;
        } else {
            FlashMsg::setMsgError("Erro ao enviar: {$email->errorInfo} ", 1);

            return false;
        }
    }

    private function preparaMsg($dados)
    {
        $msg = '<h1>Contato feito pelo Site</h1>';
        foreach ($dados as $key => $item) {
            $msg .= " <p><strong>{$key}</strong>: {$item}</p>";
        }

        return $msg;
    }
}

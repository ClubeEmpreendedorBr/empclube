<?php
$subjectPrefix = '[Contato via Site]';
$emailTo = '<YOUR_EMAIL_HERE>';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name    = stripslashes(trim($_POST['form-name']));
    $email   = stripslashes(trim($_POST['form-email']));
    $phone   = stripslashes(trim($_POST['form-tel']));
    $subject = stripslashes(trim($_POST['form-assunto']));
    $message = stripslashes(trim($_POST['form-mensagem']));
    $pattern = '/[\r\n]|Content-Type:|Bcc:|Cc:/i';
    if (preg_match($pattern, $name) || preg_match($pattern, $email) || preg_match($pattern, $subject)) {
        die("Header injection detected");
    }
    $emailIsValid = filter_var($email, FILTER_VALIDATE_EMAIL);
    if($name && $email && $emailIsValid && $subject && $message){
        $subject = "$subjectPrefix $subject";
        $body = "Nome: $name <br /> Email: $email <br /> Telefone: $phone <br /> Mensagem: $message";
        $headers .= sprintf( 'Return-Path: %s%s', $email, PHP_EOL );
        $headers .= sprintf( 'From: %s%s', $email, PHP_EOL );
        $headers .= sprintf( 'Reply-To: %s%s', $email, PHP_EOL );
        $headers .= sprintf( 'Message-ID: <%s@%s>%s', md5( uniqid( rand( ), true ) ), $_SERVER[ 'HTTP_HOST' ], PHP_EOL );
        $headers .= sprintf( 'X-Priority: %d%s', 3, PHP_EOL );
        $headers .= sprintf( 'X-Mailer: PHP/%s%s', phpversion( ), PHP_EOL );
        $headers .= sprintf( 'Disposition-Notification-To: %s%s', $email, PHP_EOL );
        $headers .= sprintf( 'MIME-Version: 1.0%s', PHP_EOL );
        $headers .= sprintf( 'Content-Transfer-Encoding: 8bit%s', PHP_EOL );
        $headers .= sprintf( 'Content-Type: text/html; charset="utf-8"%s', PHP_EOL );
        mail($emailTo, "=?utf-8?B?".base64_encode($subject)."?=", $body, $headers);
        $emailSent = true;
    } else {
        $hasError = true;
    }
}
?>

<!DOCTYPE html>
 
<html> 
 <head>
 <title>Clube de Empreendedorismo</title>
 <meta name="description" content="Existe um meio de formar empreendedores? Existe um meio de ensinar as pessoas a desenvolver a ideia de arriscar mais pelos seus sonhos?">
 <meta charset="utf-8">
 <link rel="stylesheet" type="text/css" href="style.css"/>
 <script type="text/javascript">
 </script>
</head>
 <body>
  <header>
    <section id="banner1" alt="Clube de Empreendedorismo">
	<div id="imagenslogo" align="center">
		<div id="logo">
			<img src="imagens/logo.png"/>
		</div>
		<div id="imagensbanner">
			<img src="imagens/bannerImagens.png"/>
		</div>
	</div>
    
    </section>
</header>
<section id="corposite">
	  <section id="clubesection" style="width:100%; margin-bottom:5%">
		<h1>O CLUBE</h1>
		<center>
			<div id="oclube">
				<p>O Brasil é o país mais empreendedor do mundo, entretanto falta inovação nos negócios. A inovação surge a partir de outras ideias.
				Rede de conhecimento trás possibilidades. Estar à frente de uma empresa exige muito da pessoa e uma ótima alternativa para o impasse da inovação é uma Consultoria em Gestão Coletiva. Encurte distâncias entre pessoas de sucesso utilizando o conhecimento aplicado de cada um do grupo, resolva seus problemas e proponha soluções.</p> 
		   </div>
	   </center>
	</section>
	
	
   <section id="imagensdesc" align="center"> 
	<div id="organizador">
		<div id="imgdistancia">
			<figure>
			<img src="imagens/distancia.png"/>
			<figcaption>Encurtar distâncias entre empreendedores.</figcaption>
			</figure>
		</div>
		<div id="imgeventos">
			<figure>
			<img src="imagens/eventos.png"/>
			<figcaption>Eventos e compartilhamento de experiências e ideias.</figcaption>
			</figure>
		</div>
		<div id="imgdesenvolver">
			<figure>
			<img src="imagens/desenvolver.png"/>
			<figcaption>Desenvolver e alavancar as empresas participantes.</figcaption>
			</figure>
		</div>
		<div id="imgstatusquo">
			<figure>
			<img src="imagens/statusquo.png"/>
			<figcaption>Deixar a zona de conforto e transformar o status quo.</figcaption>
			</figure>
		</div>
	</div>
   </section>


		<section id="banner2" alt="Missão, visão e valores">
			<div id="esquerda">
				<div id="visao">
				   <p>VISÃO</p>
				   <p>"Desenvolver a maior rede de empreendedores do Brasil"</p>
				</div>
				<div id="missao">
				   <p>MISSÃO</p>
				   <p>"Conectar pessoas de alto potencial empreendedor e desenvolver seus negócios"</p>
			   </div>
			   <div id="valores">
				   <p>VALORES</p>
				   <p>"Colaboração; integridade e energia no desenvolvimento de negócios; Impacto positivo no ambiente."</p>
			   </div>
			</div>
		</section>

</section>
<div class="jumbotron">
        <h1>Simple PHP Contact Form</h1>
        <p>A Simple Contact Form developed in PHP with HTML5 Form validation. Has a fallback in jQuery for browsers that do not support HTML5 form validation.</p>
    </div>
    <?php if(!empty($emailSent)): ?>
        <div class="col-md-6 col-md-offset-3">
            <div class="alert alert-success text-center">Sua mensagem foi enviada com sucesso.</div>
        </div>
    <?php else: ?>
        <?php if(!empty($hasError)): ?>
        <div class="col-md-5 col-md-offset-4">
            <div class="alert alert-danger text-center">Houve um erro no envio, tente novamente mais tarde.</div>
        </div>
        <?php endif; ?>

    <div class="col-md-6 col-md-offset-3">
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="contact-form" class="form-horizontal" role="form" method="post">
            <div class="form-group">
                <label for="name" class="col-lg-2 control-label">Nome</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="form-name" name="form-name" placeholder="Nome" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-lg-2 control-label">Email</label>
                <div class="col-lg-10">
                    <input type="email" class="form-control" id="form-email" name="form-email" placeholder="Email" required>
                </div>
            </div>
            <div class="form-group">
                <label for="tel" class="col-lg-2 control-label">Telefone</label>
                <div class="col-lg-10">
                    <input type="tel" class="form-control" id="form-tel" name="form-tel" placeholder="Telefone">
                </div>
            </div>
            <div class="form-group">
                <label for="assunto" class="col-lg-2 control-label">Assunto</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="form-assunto" name="form-assunto" placeholder="Assunto" required>
                </div>
            </div>
            <div class="form-group">
                <label for="mensagem" class="col-lg-2 control-label">Mensagem</label>
                <div class="col-lg-10">
                    <textarea class="form-control" rows="3" id="form-mensagem" name="form-mensagem" placeholder="Mensagem" required></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="submit" class="btn btn-default">Enviar</button>
                </div>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <!--[if lt IE 9]>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <![endif]-->
    <!--[if gte IE 9]><!-->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <!--<![endif]-->
    <script type="text/javascript" src="assets/js/contact-form.js"></script>



  <footer>
   <p>Todos os direitos reservados.</p>
  </footer>
 
 </body>

</html>

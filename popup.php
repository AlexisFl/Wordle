<div class="overlay" id="divOne">
		<div class="wra">
			<h2>S'inscrire</h2><a class="close" href="#">&times;</a>
			<div class="content">
				<div class="contenu">
					<form method="post" action="submit_account.php">
						<label>Pseudo</label>
						<input placeholder="Votre pseudo.." type="text" name="pseudo">
						<label>Mot de passe</label>
						<input placeholder="Votre mot de passe.." type="password" name="password" aria-describedby="pw-help">
                        <div id="pw-help" class="form-text">Le mot de passe doit être unique</div>
                        <br>
						<input type="submit" value="Valider">
					</form>
				</div>
			</div>
		</div>
	</div>
    <div class="overlay" id="divTwo">
            <div class="wra">
                <h2>Se connecter</h2><a class="close" href="#">&times;</a>
                <div class="content">
                    <div class="contenu">
                        <form method="post" action="login.php">
                            <label>Pseudo</label>
                            <input placeholder="Votre pseudo.." type="text" name="pseudo">
                            <label>Mot de passe</label>
                            <input placeholder="Votre mot de passe.." type="password" name="password">
                            <input type="submit" value="Valider">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="overlay" id="divThree">
            <div class="wra">
                <h2>Aide</h2><a class="close" href="#">&times;</a>
                <div class="content">
                    <div class="contenu">
                        <h3>Règles du jeu : </h3></br>
                        <p class="help">Pour gagner au wordle vous devez trouver un mot aléatoire avec 6 tentatives.</p></br>
                        <p class="help">Vous pouvez entrer les lettres que vous souhaitez et le jeu vous indiquera si :</p></br>
                        <p class="help">- La lettre est grise : elle n'apparait pas dans le mot</p></br>
                        <p class="help">- La lettre est jaune : elle apparait dans le mot mais pas à la bonne position</p></br>
                        <p class="help">- La lettre est verte : elle apparait dans le mot et est bien positionnée</p></br>
                        <p class="help">La taille du mot à trouver correspond au nombre de case qui compose la largeur de la grille. Vous pourrez seulement tester
                        des mots qui font cette taille.</p></br>
                        <h3>Fonctionnalités du site :</h3></br>
                        <p class="help">Vous pourrez vous créer un compte et vous connecter, ce dernier vous permettrat de pouvoir apparaître dans le classement.</p></br>
                        <p class="help">Dans le menu vous aurez accès au mot du jour ou alors aux différents niveaux de difficultés :</p></br>
                        <p class="help">- Facile : Le mot contient 5 à 6 lettres</p></br>
                        <p class="help">- Moyen : Le mot contient 7 à 8 lettres</p></br>
                        <p class="help">- Difficile : Le mot contient 9 lettre ou plus</p></br>
                        <p class="help">Dans le menu vous pouvez jouer le mot du jour et dans la bar de navigation vous aurez accès aux mot du jour des 6 mois précédent.</p></br>
                    </div>
                </div>
            </div>
        </div>
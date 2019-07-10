<?php 
	require_once 'dbconnect.php';
?>
<html>
<head>
    <title>Chess Tactics with Saliency</title>
    <link rel="stylesheet" href="css/chessboard-1.0.0.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="js/chessboard-1.0.0.min.js"></script>
    <script src="js/chessboard-1.0.0.js"></script>
    <script src="js/chess.js"></script>
    <script src="js/pgns.js"></script>
    <script src="js/chess.min.js"></script>
</head>

<body>
	<div style="width: 1000px">
	    <div id="myBoard" style="width: 400px; float: left;"></div>
	    <div id='map' style="width: 400px; float: right;"></div>
    </div>
    <!-- <input type="button" id="startPositionBtn5" value="|<" />
	<input type="button" id="prevBtn5" value="<" />
	<input type="button" id="nextBtn5" value=">" />
	<input type="button" id="endPositionBtn5" value=">|" />
	 --><p id="pgn5"></p>
	</div>
	<script type="text/javascript">
		$(function() {
			// const fs = require('fs')
			function onDragStart (source, piece, position, orientation) {
	  			// do not pick up pieces if the game is over
				if (game.game_over()) return false
				// only pick up pieces for the side to move
				if ((game.turn() === 'w' && piece.search(/^b/) !== -1) ||
				  (game.turn() === 'b' && piece.search(/^w/) !== -1)) {
				return false
				}
			}
			function onDrop (source, target) {
				// see if the move is legal
				var move = game.move({
					from: source,
					to: target,
					promotion: 'q' // NOTE: always promote to a queen for example simplicity
				})
				if (source == target) return 'snapback'
				// illegal move
				if (move === null) return 'snapback'
				
				if(source != history[i].from || target != history[i].to){
					alert('Wrong move played. You played: ' + source + target + '. Required move: ' + history[i].from + history[i].to);
					
				    var form = document.createElement("form");
				    var element1 = document.createElement("input"); 
				    var element2 = document.createElement("input");  
				    var element3 = document.createElement("input");  
				    var element4 = document.createElement("input");  

				    form.method = "POST";
				    form.action = "submit.php";   

				    element1.value=idx;
				    element1.name="idx";
				    form.appendChild(element1);  

				    element2.value=show_saliency;
				    element2.name="sal";
				    form.appendChild(element2);

				    element3.value=0;
				    element3.name="solve";
				    form.appendChild(element3);

				    element4.value=-1;
				    element4.name="time_t";
				    form.appendChild(element4);

				    document.body.appendChild(form);

				    form.submit();
					
					return 'snapback'
				}
				i+=1
				if(i >= history.length) {
					var endDate = new Date();
					var end = endDate.getTime()
					var time = (end - start)/1000.0						
					var form = document.createElement("form");
				    var element1 = document.createElement("input"); 
				    var element2 = document.createElement("input");  
				    var element3 = document.createElement("input");  
				    var element4 = document.createElement("input");  

				    form.method = "POST";
				    form.action = "submit.php";   

				    element1.value=idx;
				    element1.name="idx";
				    form.appendChild(element1);  

				    element2.value=show_saliency;
				    element2.name="sal";
				    form.appendChild(element2);

				    element3.value=1;
				    element3.name="solve";
				    form.appendChild(element3);

				    element4.value=time;
				    element4.name="time_t";
				    form.appendChild(element4);

				    document.body.appendChild(form);

					alert('Good going. Time taken: ' + time)
				    form.submit();
					
					return true
					
				}
				else {
					game.move(history[i].san)
					i+=1	
				}
			}
			// update the board position after the piece snap
			// for castling, en passant, pawn promotion
			function onSnapEnd () {
				board.position(game.fen())
			}
			// var show_saliency = (Math.random() > 0.5)
			var tempDate = new Date();
			var temp = tempDate.getTime();
			var show_saliency = (temp%2 == 0); 
			if(show_saliency){
				alert("Play the tactic for white on the board on the left. You can take help from the board on the right which highlights important pieces for the tactic. Time will start when you click on OK.");
			}
			else {
				alert("Play the tactic for white on the board on the left. Time will start when you click on OK.")
			}

			var idx = Math.floor(Math.random() * 29);

			if(show_saliency) {
				document.getElementById('map').innerHTML = '<img src="maps/' + idx + '.png">'
			}

			console.log(idx)
			var board = null
			var config = {
				position: list_of_fens[idx],
				draggable: true,
				onDragStart: onDragStart,
				onDrop: onDrop,
				onSnapEnd: onSnapEnd
			}
			var game = new Chess();
			board = ChessBoard('myBoard', config);
			
			// 1. Load a PGN into the game
			pgn = list_of_pgns[idx];
			game.load_pgn(list_of_pgns[idx].join('\n'));

			
			// 2. Get the full move history
			var history = game.history({verbose: true});
			game.load(list_of_fens[idx]);
			var i = 0;
			var d = new Date();
			var start = d.getTime();
			// 3. If Next button clicked, move forward one
			// $('#nextBtn5').on('click', function() {
			// 	game.move(history[i].san);
			// 	board.position(game.fen());
			// 	i += 1;
			// 	if (i > history.length) {
			// 	  i = history.length;
			// 	}
			// });			
			// // 4. If Prev button clicked, move backward one
			// $('#prevBtn5').on('click', function() {
			// 	game.undo();
			// 	board.position(game.fen());
			// 	i -= 1;
			// 	if (i < 0) {
			// 		i = 0;
			// 	}
			// });
			// // 5. If Start button clicked, go to start position
			// $('#startPositionBtn5').on('click', function() {
			// 	game.load(list_of_fens[idx]);
			// 	board.start();
			// 	i = 0;
			// });
			// // 6. If End button clicked, go to end position
			// $('#endPositionBtn5').on('click', function() {
			// 	game.load_pgn(pgn);
			// 	board.position(game.fen());
			// 	i = history.length;
			// });
		});
	</script>
</body>
</html>
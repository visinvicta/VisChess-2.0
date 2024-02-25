var board = null
var game = new Chess()
var $status = $('#status')
var $fen = $('#fen')
var $pgn = $('#pgn')
board = Chessboard('analysisboard', config)
updateStatusAll()

function updateStatusAll() {
  var status = ''

  var moveColor = 'White'
  if (game.turn() === 'b') {
    moveColor = 'Black'
  }

  if (game.in_checkmate()) {
    status = 'Game over, ' + moveColor + ' is in checkmate.'
  }

  else if (game.in_draw()) {
    status = 'Game over, drawn position'
  }

  else {
    status = moveColor + ' to move'

    if (game.in_check()) {
      status += ', ' + moveColor + ' is in check'
    }
  }

  board.position(game.fen());
  $status.html(status)
  $fen.html(game.fen())
  $pgn.html(game.pgn())
}

function updateStatusNoPGN(status) {
  board.position(game.fen());
  $status.html(status)
  $fen.html(game.fen())
}

var config = {
  position: 'start',
}

let currentMove = 0;
let gamePGN = '';
let moveCount = [];

const importField = document.getElementById("importpgn");
const importButton = document.getElementById("importpgnsubmit");

importButton.addEventListener("click", function () {
  game.load_pgn(importField.value);
  gamePGN = importField.value;
  pgnNoNumbers = gamePGN.replace(/\d+\.\s+/g, '').split(/\s+/).filter(move => move.trim() !== '');
  moveCount = pgnNoNumbers.length
  currentMove = pgnNoNumbers.length;
  updateStatusAll();
})

function nextMove() {
  let newPGN = pgnNoNumbers.slice(0, currentMove).join(' ');
  game.load_pgn(newPGN);
  updateStatusNoPGN();
}

const leftscroll = document.getElementById("leftscroll");
const rightscroll = document.getElementById("rightscroll");

leftscroll.addEventListener('click', function () {
  if (currentMove > 0) {
    currentMove--;
    nextMove();
  };
});

rightscroll.addEventListener('click', function () {
  if (currentMove < moveCount) {
    currentMove++;
    nextMove();
  }
  console.log(`Game Move Count: ${currentMove}`);
});

document.addEventListener('keydown', function (event) {
  if (event.key === 'ArrowLeft') {
    if (currentMove > 0) {
      currentMove--;
      nextMove();
    };

  } else if (event.key === 'ArrowRight') {
    if (currentMove < moveCount) {
      currentMove++;
      nextMove();
    }
  }
  console.log(`Game Move Count: ${currentMove}`);
});

function flipBoard() {
  board.flip();
}

const flipboard = document.getElementById("flipboard");
flipboard.addEventListener("click", () => flipBoard());

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

async function sendDataToServer(endpoint) {
  try {
    if (moveCount !== '') {
      const response = await fetch(endpoint, {
        method: 'POST',
        headers: {
          'Content-type': 'application/json',
          'X-CSRF-TOKEN': csrfToken  
        },
        body: JSON.stringify({ 
          "pgn": gamePGN,
          "user_id": 1,
          "whiteplayer": 'Carlsen, Magnus',
          "blackplayer": 'Nakamura, Hikaru',
          "result": 'unknown'

        })
      });

      if (!response.ok) {
        throw new Error('Failed to post data to server');
      }

      const data = await response.text();
      console.log(data);
    }
  } catch (error) {
    console.error('Error:', error.message);
  }
}

const dbbutton = document.getElementById("posttodb");
if (dbbutton) {
  dbbutton.addEventListener("click", () => sendDataToServer('/games'));
}

const mygamesbutton = document.getElementById("posttomygames");
if (mygamesbutton) {
  mygamesbutton.addEventListener("click", () => sendDataToServer('/favorites'));
}

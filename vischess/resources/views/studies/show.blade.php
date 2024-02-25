@extends('layout')

@section('content')
<div class="content">
    <div class="main">
        <div class="header">
            <h1>Study</h1>
            <h2>{{ $study->name }}</h2>
        </div>
        <!-- Button to trigger the modal -->
        <a href="#" class="btn btn-color-1 btn-study btn-study-create" data-toggle="modal" data-target="#createChapterModal">Chapter +</a>

        <div class="study-container">
            <div class="sidebar">
                <h3>Chapters</h3>
                <ul class="chapter-list">
                    @foreach ($chapters as $chapter)
                    <li id="{{ $chapter->id}}">{{ $chapter->name }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="main-content">
                <div class="study-board">
                    <div class="study-chessboard">
                        <div id="studyboard" style="width: 500px"></div>
                        <div class="study-btn-container">
                            <button id="leftscroll" class="btn btn-color-1"><-</button>
                                    <button id="rightscroll" class="btn btn-color-2">-></button>
                                    <button id="flipboard" class="btn btn-color-5">Flip</button>
                        </div>
                        <label>PGN:</label>
                        <div class="comment studypgn" id="pgn" type="text"></div>
                        <label>Comment:</label>
                        <div class="comment" id="comment" type="text">
                            @foreach ($comments as $comment)
                            <div class="move-{{ $comment->move_number }} chapter-{{ $comment->chapter_id }} comment-item" style="display: none;">{{ $comment->comment }}</div>
                            @endforeach
                        </div>
                        <button id="addcomment" class="btn btn-color-5">Add comment</button>
                    </div>
                </div>
            </div>

            <div class="moves-table-container">
                <table class="moves-table">
                    <thead>
                        <tr>
                            <th>Move</th>
                            <th>White</th>
                            <th>Black</th>
                        </tr>
                    </thead>
                    <tbody class="moves-table-body" id="moves-table-body">
                        <!-- Move rows will be dynamically added here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="modal-overlay" id="modalOverlay"></div>


    <div class="modal fade" id="createChapterModal" tabindex="-1" role="dialog" aria-labelledby="createChapterModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="createChapterModalLabel">Create New Chapter</h2>

                </div>
                <div class="modal-body">

                    <form id="createChapterForm">
                        <input type="hidden" name="study_id" value="{{ $study->id }}">

                        <div class="form-group">
                            <label for="chapterName">Chapter Name</label>
                            <input type="text" class="form-control" id="chapterName" name="name">
                        </div>
                        <div class="form-group">
                            <label for="pgn">PGN</label>
                            <textarea class="form-control" id="modalpgn" name="pgn"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="startingMove">Starting Move</label>
                            <input type="text" class="form-control" id="startingMove" name="startingMove">

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-color-1 btn-secondary close" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-color-1 btn-primary" id="createChapterBtn">Create Chapter</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addCommentModal" tabindex="-1" role="dialog" aria-labelledby="addCommentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="addCommentModalLabel">Add Comment</h2>

                </div>
                <div class="modal-body">
                    <form id="addCommentForm">
                        <input type="hidden" name="study_id" value="{{ $study->id }}">
                        <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">

                        <div class="form-group">
                            <label for="moveNumber">Move Number</label>
                            <input type="number" class="form-control" id="moveNumber" name="move_number" min="1">
                        </div>
                        <div class="form-group">
                            <label for="commentText">Comment</label>
                            <textarea class="form-control comment-modal" id="commentText" name="comment"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-color-1 btn-secondary close" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-color-1 btn-primary" id="addCommentBtn">Add Comment</button>
                </div>
            </div>
        </div>
    </div>


    <footer>
        <script type="module" src="{{ asset('/js/study.js') }}"></script>
        <script src="{{ asset('/js/studyChapterModal.js') }}"></script>
        <script src="{{ asset('/js/studyCommentModal.js') }}"></script>
    </footer>
    @endsection
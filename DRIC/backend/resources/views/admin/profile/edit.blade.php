@php
    $photoUrl = $user->profile_photo_path ? asset('storage/'.$user->profile_photo_path) : null;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Panel DRIC</title>
    <style>
        :root {
            --blue: #164194;
            --blue-dark: #0f2f6f;
            --red: #b5121b;
            --ink: #172033;
            --muted: #647084;
            --line: #e2e8f0;
            --soft: #f5f7fb;
            --white: #fff;
            --green: #047857;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 32px;
            background:
                radial-gradient(circle at top left, rgba(22, 65, 148, 0.16), transparent 34rem),
                radial-gradient(circle at bottom right, rgba(181, 18, 27, 0.09), transparent 30rem),
                linear-gradient(180deg, #f4f7fb 0%, #edf2f7 100%);
            color: var(--ink);
            font-family: Arial, sans-serif;
        }

        .shell {
            max-width: 980px;
            margin: 0 auto;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: center;
            margin-bottom: 18px;
        }

        .eyebrow {
            margin: 0 0 8px;
            color: var(--blue);
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 0.17em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            font-size: clamp(34px, 5vw, 54px);
            line-height: 1;
            letter-spacing: -0.04em;
        }

        .layout {
            display: grid;
            grid-template-columns: 300px minmax(0, 1fr);
            gap: 18px;
        }

        .panel,
        .form-card,
        .alert {
            border: 1px solid rgba(22, 65, 148, 0.10);
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
        }

        .panel {
            padding: 24px;
            align-self: start;
        }

        .avatar-wrap {
            position: relative;
            width: fit-content;
            margin: 0 auto 14px;
        }

        .avatar {
            width: 138px;
            height: 138px;
            margin: 0;
            border: 5px solid #fff;
            border-radius: 38px;
            overflow: hidden;
            position: relative;
            color: #fff;
            background: linear-gradient(135deg, var(--blue), #2d6cdf);
            box-shadow: 0 18px 34px rgba(22, 65, 148, 0.24);
        }

        .avatar img {
            display: block;
            inset: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar svg {
            left: 50%;
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 54px;
            height: 54px;
        }

        .avatar img:not(.is-hidden) + svg {
            display: none;
        }

        .avatar img.is-hidden {
            display: none;
        }

        .photo-remove {
            position: absolute;
            top: 3px;
            right: 3px;
            z-index: 2;
            width: 24px;
            height: 24px;
            min-height: 24px;
            padding: 0;
            border: 2px solid #fff;
            border-radius: 999px;
            background: #dc2626;
            color: #fff;
            box-shadow: 0 8px 18px rgba(220, 38, 38, 0.26);
        }

        .photo-remove::before,
        .photo-remove::after {
            content: "";
            position: absolute;
            left: 50%;
            top: 50%;
            width: 12px;
            height: 2px;
            border-radius: 999px;
            background: #fff;
            transform-origin: center;
        }

        .photo-remove::before {
            transform: translate(-50%, -50%) rotate(45deg);
        }

        .photo-remove::after {
            transform: translate(-50%, -50%) rotate(-45deg);
        }

        .photo-remove[hidden] {
            display: none;
        }

        .photo-remove svg {
            display: none;
        }

        .profile-photo-tools {
            display: grid;
            gap: 8px;
            justify-items: center;
            margin: 0 auto 18px;
        }

        .panel h2 {
            margin: 0;
            text-align: center;
            font-size: 22px;
            line-height: 1.2;
        }

        .panel p {
            margin: 8px 0 0;
            color: var(--muted);
            text-align: center;
            line-height: 1.5;
        }

        .role-pill {
            width: fit-content;
            margin: 18px auto 0;
            padding: 8px 12px;
            border-radius: 999px;
            background: #ecfdf5;
            color: var(--green);
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .form-card {
            padding: 26px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            column-gap: 16px;
            row-gap: 20px;
        }

        .field {
            display: grid;
            gap: 8px;
            align-content: start;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        label {
            color: var(--blue-dark);
            font-size: 13px;
            font-weight: 900;
            text-transform: uppercase;
        }

        input {
            display: block;
            width: 100%;
            min-height: 48px;
            padding: 12px 14px;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: #fff;
            color: var(--ink);
            font-size: 16px;
        }

        input:focus {
            outline: 3px solid rgba(22, 65, 148, 0.14);
            border-color: rgba(22, 65, 148, 0.45);
        }

        input[type="file"] {
            padding: 11px;
            color: var(--muted);
        }

        .photo-control {
            display: grid;
            gap: 8px;
            justify-items: center;
        }

        .photo-input {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
        }

        .photo-picker {
            width: 138px;
            min-height: 38px;
            padding: 7px 11px;
            border-radius: 12px;
            font-size: 13px;
        }

        .hint {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .password-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            column-gap: 16px;
            row-gap: 8px;
        }

        .password-row .hint {
            grid-column: 1 / -1;
        }

        .error {
            color: var(--red);
            font-size: 13px;
            font-weight: 700;
        }

        .alert {
            margin-bottom: 18px;
            padding: 14px 16px;
            color: var(--green);
            font-weight: 800;
        }

        .actions {
            width: min(100%, 360px);
            margin: 22px 0 0 auto;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .btn {
            width: 100%;
            min-height: 48px;
            box-sizing: border-box;
            padding: 12px 16px;
            border: 0;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            color: inherit;
            text-decoration: none;
            font-family: inherit;
            font-size: 14px;
            font-weight: 900;
            line-height: 1.2;
            cursor: pointer;
            appearance: none;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        .btn.photo-remove {
            width: 24px;
            min-height: 24px;
        }

        .btn.photo-picker {
            width: 138px;
            min-height: 38px;
            padding: 7px 11px;
            border-radius: 12px;
            font-size: 13px;
        }

        .topbar > .btn {
            width: auto;
            min-width: 170px;
            min-height: 46px;
            padding: 12px 16px;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 14px 28px rgba(22, 65, 148, 0.22);
        }

        .btn-secondary {
            border: 1px solid rgba(22, 65, 148, 0.14);
            background: #edf2fb;
            color: var(--blue-dark);
        }

        .crop-modal {
            align-items: center;
            background: rgba(2, 6, 23, 0.74);
            display: none;
            inset: 0;
            justify-content: center;
            padding: 20px;
            position: fixed;
            z-index: 50;
        }

        .crop-modal.is-open {
            display: flex;
        }

        .crop-dialog {
            width: min(100%, 760px);
            max-height: calc(100vh - 40px);
            overflow: auto;
            padding: 22px;
            border: 1px solid var(--line);
            border-radius: 24px;
            background: #fff;
            box-shadow: 0 34px 90px rgba(2, 6, 23, 0.34);
        }

        .crop-top {
            display: flex;
            gap: 16px;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 16px;
        }

        .crop-top h2 {
            margin: 0 0 6px;
            font-size: 24px;
            line-height: 1.1;
        }

        .crop-stage {
            align-items: center;
            background: #020617;
            border-radius: 18px;
            display: flex;
            justify-content: center;
            min-height: 340px;
            overflow: hidden;
            padding: 18px;
            touch-action: none;
        }

        .crop-frame {
            width: min(100%, 420px);
            aspect-ratio: 1 / 1;
            border: 2px solid #fff;
            border-radius: 34px;
            box-shadow: 0 0 0 999px rgba(2, 6, 23, 0.58), 0 18px 44px rgba(0, 0, 0, 0.3);
            cursor: grab;
            overflow: hidden;
            position: relative;
        }

        .crop-frame.is-dragging {
            cursor: grabbing;
        }

        .crop-frame img {
            left: 50%;
            max-width: none;
            position: absolute;
            top: 50%;
            transform-origin: center;
            user-select: none;
            -webkit-user-drag: none;
        }

        .crop-controls {
            align-items: center;
            display: grid;
            gap: 12px;
            grid-template-columns: auto minmax(160px, 1fr);
            margin: 16px 0;
        }

        .crop-controls input {
            min-height: 0;
            padding: 0;
        }

        .crop-actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-left: auto;
            width: min(100%, 360px);
        }

        svg {
            width: 22px;
            height: 22px;
            stroke: currentColor;
            stroke-width: 2.2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        @media (max-width: 820px) {
            body {
                padding: 20px;
            }

            .topbar,
            .layout,
            .grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                align-items: stretch;
                flex-direction: column;
            }

            .btn,
            .actions {
                width: 100%;
            }

            .password-row,
            .actions,
            .crop-actions {
                grid-template-columns: 1fr;
            }

            .crop-top {
                display: grid;
            }
        }
    </style>
</head>
<body>
    <main class="shell">
        <div class="topbar">
            <div>
                <p class="eyebrow">Panel DRIC</p>
                <h1>Perfil</h1>
            </div>
            <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
                Volver al panel
            </a>
        </div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <section class="layout">
            <aside class="panel" aria-label="Resumen del perfil">
                <div class="avatar-wrap">
                    <div class="avatar" aria-hidden="true">
                        @if ($photoUrl)
                            <img src="{{ $photoUrl }}" alt="" data-avatar-image>
                            <svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
                        @else
                            <img class="is-hidden" src="" alt="" data-avatar-image>
                            <svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
                        @endif
                    </div>
                    <button class="btn photo-remove" type="button" id="photo-remove" aria-label="Quitar foto" @unless ($photoUrl) hidden @endunless>
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>

                <div class="profile-photo-tools">
                    <div class="photo-control">
                        <input class="photo-input" id="profile_photo" name="profile_photo" type="file" accept="image/png,image/jpeg,image/webp" form="profile-form">
                        <input id="remove_profile_photo" name="remove_profile_photo" type="hidden" value="0" form="profile-form">
                        <label class="btn btn-secondary photo-picker" for="profile_photo">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                            Editar
                        </label>
                        <p class="hint" id="photo-file-name">Ninguna imagen nueva seleccionada.</p>
                        @error('profile_photo') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <p class="hint">JPG, PNG o WebP. Maximo 2 MB.</p>
                </div>

                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>
                <div class="role-pill">Editor</div>
            </aside>

            <form class="form-card" id="profile-form" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid">
                    <div class="field">
                        <label for="name">Nombre</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" autocomplete="name" required>
                        @error('name') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="email">Gmail</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" autocomplete="email" required>
                        @error('email') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="password-row field full">
                        <div class="field">
                            <label for="password">Nueva contrasena</label>
                            <input id="password" name="password" type="password" autocomplete="new-password">
                            @error('password') <div class="error">{{ $message }}</div> @enderror
                        </div>

                        <div class="field">
                            <label for="password_confirmation">Confirmar contrasena</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                        </div>

                        <p class="hint">Dejala vacia si no quieres cambiarla.</p>
                    </div>
                </div>

                <div class="actions">
                    <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Cancelar</a>
                    <button class="btn btn-primary" type="submit">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                        Guardar perfil
                    </button>
                </div>
            </form>
        </section>
    </main>

    <div class="crop-modal" id="crop-modal" aria-hidden="true">
        <div class="crop-dialog" role="dialog" aria-modal="true" aria-labelledby="crop-title">
            <div class="crop-top">
                <div>
                    <h2 id="crop-title">Recortar foto</h2>
                    <p class="hint">Ajusta la imagen dentro del marco cuadrado para que se vea bien en tu perfil.</p>
                </div>
                <button class="btn btn-secondary" type="button" id="crop-close">Cancelar</button>
            </div>

            <div class="crop-stage">
                <div class="crop-frame" id="crop-frame">
                    <img id="crop-image" alt="Imagen para recortar">
                </div>
            </div>

            <label class="crop-controls">
                Zoom
                <input type="range" id="crop-zoom" min="1" max="3" step="0.01" value="1">
            </label>

            <div class="crop-actions">
                <button class="btn btn-secondary" type="button" id="crop-reset">Centrar</button>
                <button class="btn btn-primary" type="button" id="crop-accept">Aceptar recorte</button>
            </div>
        </div>
    </div>

    <script>
        const fileInput = document.getElementById("profile_photo");
        const photoRemoveInput = document.getElementById("remove_profile_photo");
        const photoRemoveButton = document.getElementById("photo-remove");
        const fileName = document.getElementById("photo-file-name");
        const avatarImage = document.querySelector("[data-avatar-image]");
        const avatarIcon = document.querySelector(".avatar svg");
        const cropModal = document.getElementById("crop-modal");
        const cropFrame = document.getElementById("crop-frame");
        const cropImage = document.getElementById("crop-image");
        const cropZoom = document.getElementById("crop-zoom");
        const cropAccept = document.getElementById("crop-accept");
        const cropReset = document.getElementById("crop-reset");
        const cropClose = document.getElementById("crop-close");
        const cropState = {
            file: null,
            objectUrl: "",
            naturalWidth: 0,
            naturalHeight: 0,
            baseScale: 1,
            zoom: 1,
            offsetX: 0,
            offsetY: 0,
            dragging: false,
            pointerX: 0,
            pointerY: 0,
        };

        function updateCropImage() {
            const imageWidth = cropState.naturalWidth * cropState.baseScale * cropState.zoom;
            const imageHeight = cropState.naturalHeight * cropState.baseScale * cropState.zoom;
            const maxX = Math.max(0, (imageWidth - cropFrame.clientWidth) / 2);
            const maxY = Math.max(0, (imageHeight - cropFrame.clientHeight) / 2);

            cropState.offsetX = Math.min(maxX, Math.max(-maxX, cropState.offsetX));
            cropState.offsetY = Math.min(maxY, Math.max(-maxY, cropState.offsetY));

            cropImage.style.width = `${imageWidth}px`;
            cropImage.style.height = `${imageHeight}px`;
            cropImage.style.transform = `translate(calc(-50% + ${cropState.offsetX}px), calc(-50% + ${cropState.offsetY}px))`;
        }

        function resetCropPosition() {
            cropState.baseScale = Math.max(
                cropFrame.clientWidth / cropState.naturalWidth,
                cropFrame.clientHeight / cropState.naturalHeight
            );
            cropState.zoom = 1;
            cropState.offsetX = 0;
            cropState.offsetY = 0;
            cropZoom.value = "1";
            updateCropImage();
        }

        function openCropTool(file) {
            if (cropState.objectUrl) {
                URL.revokeObjectURL(cropState.objectUrl);
            }

            cropState.file = file;
            cropState.objectUrl = URL.createObjectURL(file);
            cropModal.classList.add("is-open");
            cropModal.setAttribute("aria-hidden", "false");
            cropImage.src = cropState.objectUrl;
        }

        function closeCropTool(clearInput = false) {
            cropModal.classList.remove("is-open");
            cropModal.setAttribute("aria-hidden", "true");
            cropFrame.classList.remove("is-dragging");
            cropState.dragging = false;

            if (clearInput) {
                fileInput.value = "";
                fileName.textContent = "Ninguna imagen nueva seleccionada.";
            }

            if (cropState.objectUrl) {
                URL.revokeObjectURL(cropState.objectUrl);
            }

            cropState.file = null;
            cropState.objectUrl = "";
            cropImage.removeAttribute("src");
        }

        function setImagePreview(file) {
            const reader = new FileReader();

            reader.addEventListener("load", () => {
                avatarImage.src = reader.result;
                avatarImage.classList.remove("is-hidden");
                avatarIcon?.setAttribute("hidden", "");
                photoRemoveInput.value = "0";
                photoRemoveButton.hidden = false;
            });

            reader.readAsDataURL(file);
            fileName.textContent = file.name;
        }

        function removeProfilePhoto() {
            fileInput.value = "";
            photoRemoveInput.value = "1";
            avatarImage.removeAttribute("src");
            avatarImage.classList.add("is-hidden");
            avatarIcon?.removeAttribute("hidden");
            photoRemoveButton.hidden = true;
            fileName.textContent = "La foto se quitara al guardar.";
        }

        function acceptCrop() {
            if (!cropState.file) return;

            const scale = cropState.baseScale * cropState.zoom;
            const visibleLeft = (cropState.naturalWidth * scale - cropFrame.clientWidth) / 2 - cropState.offsetX;
            const visibleTop = (cropState.naturalHeight * scale - cropFrame.clientHeight) / 2 - cropState.offsetY;
            const sourceX = Math.max(0, visibleLeft / scale);
            const sourceY = Math.max(0, visibleTop / scale);
            const sourceSize = Math.min(
                cropState.naturalWidth - sourceX,
                cropState.naturalHeight - sourceY,
                cropFrame.clientWidth / scale,
                cropFrame.clientHeight / scale
            );
            const canvas = document.createElement("canvas");
            canvas.width = 900;
            canvas.height = 900;
            const context = canvas.getContext("2d");

            context.drawImage(cropImage, sourceX, sourceY, sourceSize, sourceSize, 0, 0, 900, 900);
            canvas.toBlob((blob) => {
                if (!blob) return;

                const baseName = cropState.file.name.replace(/\.[^.]+$/, "") || "perfil";
                const cropped = new File([blob], `${baseName}-perfil.jpg`, { type: "image/jpeg" });
                const transfer = new DataTransfer();

                transfer.items.add(cropped);
                fileInput.files = transfer.files;
                setImagePreview(cropped);
                closeCropTool();
            }, "image/jpeg", 0.9);
        }

        fileInput.addEventListener("change", () => {
            const file = fileInput.files?.[0];

            if (!file) return;

            if (!file.type.startsWith("image/")) {
                fileName.textContent = "Selecciona una imagen valida.";
                fileInput.value = "";
                return;
            }

            openCropTool(file);
        });

        cropImage.addEventListener("load", () => {
            cropState.naturalWidth = cropImage.naturalWidth;
            cropState.naturalHeight = cropImage.naturalHeight;
            requestAnimationFrame(resetCropPosition);
        });

        cropZoom.addEventListener("input", () => {
            cropState.zoom = Number(cropZoom.value);
            updateCropImage();
        });

        cropFrame.addEventListener("pointerdown", (event) => {
            cropState.dragging = true;
            cropState.pointerX = event.clientX;
            cropState.pointerY = event.clientY;
            cropFrame.classList.add("is-dragging");
            cropFrame.setPointerCapture(event.pointerId);
        });

        cropFrame.addEventListener("pointermove", (event) => {
            if (!cropState.dragging) return;

            cropState.offsetX += event.clientX - cropState.pointerX;
            cropState.offsetY += event.clientY - cropState.pointerY;
            cropState.pointerX = event.clientX;
            cropState.pointerY = event.clientY;
            updateCropImage();
        });

        cropFrame.addEventListener("pointerup", (event) => {
            cropState.dragging = false;
            cropFrame.classList.remove("is-dragging");
            cropFrame.releasePointerCapture(event.pointerId);
        });

        cropFrame.addEventListener("pointercancel", () => {
            cropState.dragging = false;
            cropFrame.classList.remove("is-dragging");
        });

        cropReset.addEventListener("click", resetCropPosition);
        cropAccept.addEventListener("click", acceptCrop);
        cropClose.addEventListener("click", () => closeCropTool(true));
        photoRemoveButton.addEventListener("click", removeProfilePhoto);
        cropModal.addEventListener("click", (event) => {
            if (event.target === cropModal) {
                closeCropTool(true);
            }
        });
        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape" && cropModal.classList.contains("is-open")) {
                closeCropTool(true);
            }
        });
    </script>
</body>
</html>

<script>
    function initSkeleton(skeletonId, contentId, delay = 1000) {
        const skeleton = document.getElementById(skeletonId);
        const content = document.getElementById(contentId);

        // Gunakan sessionStorage key unik berdasarkan halaman
        const pageKey = `skeleton-loaded-${window.location.pathname}`;

        if (sessionStorage.getItem(pageKey) === 'true') {
            // Kalau sudah pernah diload, langsung sembunyikan skeleton
            skeleton?.classList.add("hidden");
            content?.classList.remove("hidden");
        } else {
            // Tampilkan skeleton lalu simpan status di sessionStorage
            setTimeout(() => {
                skeleton?.classList.add("hidden");
                content?.classList.remove("hidden");
                sessionStorage.setItem(pageKey, 'true');
            }, delay);
        }
    }


    // function initSubmitLoader(loaderId, buttonId, contentId = null) {
    //     const content = document.getElementById(contentId);
    //     const loader = document.getElementById(loaderId);
    //     const button = document.getElementById(buttonId);

    //     button?.addEventListener("click", function () {
    //         content?.classList.remove("hidden");
    //         loader?.classList.remove("hidden");
    //         button.classList.add("cursor-not-allowed", "opacity-70");
    //     });

    //     hideSubmitLoader(loaderId, buttonId, contentId);
    // }

    // function hideSubmitLoader(loaderId, buttonId, contentId = null) {
    //     const content = document.getElementById(contentId);
    //     const loader = document.getElementById(loaderId);
    //     const button = document.getElementById(buttonId);

    //     content?.classList.add("hidden");
    //     loader?.classList.add("hidden");
    //     button?.classList.remove("cursor-not-allowed", "opacity-70");
    //     // console.log(`Status loading (${buttonId}): sudah`);
    // }

    // 🔁 Init Submit Loader
    // function initSubmitLoaders() {
    //     document.querySelectorAll("form[data-submit-loader]").forEach(form => {
    //         form.addEventListener("submit", () => {
    //             const loaderSelector = form.getAttribute("data-loader");
    //             const buttonSelector = form.getAttribute("data-submit-button");
    //             const loader = document.querySelector(loaderSelector);
    //             const button = document.querySelector(buttonSelector);

    //             loader?.classList.remove("hidden");
    //             button?.classList.add("cursor-not-allowed", "opacity-70");
    //             button.disabled = true;
    //         });
    //     });
    // }

    function initSubmitLoaders() {
        document.querySelectorAll("[data-submit-loader]").forEach(button => {
            const loaderSelector = button.getAttribute("data-loader");
            const contentSelector = button.getAttribute("data-content");

            const loader = loaderSelector ? document.querySelector(loaderSelector) : null;
            const content = contentSelector ? document.querySelector(contentSelector) : null;

            button.addEventListener("click", () => {
                content?.classList.remove("hidden");
                loader?.classList.remove("hidden");
                button.classList.add("cursor-not-allowed", "opacity-70");
            });

            // Optional: simpan fungsi reset ke dalam window untuk nanti dipanggil
            const buttonId = button.id;
            window[`hideSubmitLoader_${buttonId}`] = () => {
                content?.classList.add("hidden");
                loader?.classList.add("hidden");
                button.classList.remove("cursor-not-allowed", "opacity-70");
            };

            window.hideSubmitLoader_submitSearchUser?.();

        });
    }


    function initImagePreview(inputId, containerId, submitButtonId, maxSizeMB = 2) {
        const input = document.getElementById(inputId);
        const container = document.getElementById(containerId);
        const submitButton = document.getElementById(submitButtonId);
        const initialsSpan = container?.querySelector("span");

        input?.addEventListener("change", function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    container.style.backgroundImage = `url('${e.target.result}')`;
                    container.style.backgroundSize = "cover";
                    container.style.backgroundPosition = "center";
                    initialsSpan?.style && (initialsSpan.style.display = "none");
                    submitButton?.classList.remove("hidden");
                };
                reader.readAsDataURL(file);
            }
        });
    }
</script><?php /**PATH /home/user/php-praktikum-sipil/resources/Views/dashboard/layouts/script.blade.php ENDPATH**/ ?>
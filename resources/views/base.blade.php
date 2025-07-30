<script>
    // Liste simulée des utilisateurs (vous pouvez remplacer par une API ou une base de données)
    var usersArray = @json($users);
    const users = usersArray.map(user => user.email);

    // Récupérer les éléments HTML
    const userInput = document.getElementById("user_input");
    const userDropdown = document.getElementById("user_dropdown");

    // Fonction pour afficher les suggestions
    const showSuggestions = (query) => {
        // Filtrer les utilisateurs par le texte saisi
        const matches = users.filter(user => user.toLowerCase().includes(query.toLowerCase()));

        // Vider les options précédentes
        userDropdown.innerHTML = "";

        // Si aucune correspondance, cacher la liste
        if (matches.length === 0) {
            userDropdown.classList.add("hidden");
            return;
        }

        // Afficher les correspondances
        matches.forEach(user => {
            const li = document.createElement("li");
            li.textContent = user;
            li.className = "p-2 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600";
            li.addEventListener("click", () => {
                userInput.value += `-${user} `;
                userDropdown.classList.add("hidden");
            });
            userDropdown.appendChild(li);
        });

        // Afficher la liste déroulante
        userDropdown.classList.remove("hidden");
    };

    // Événement de saisie dans le champ d'entrée
    userInput.addEventListener("input", (e) => {
        const value = e.target.value;
        const lastWord = value.split(" ").pop(); // Dernier mot saisi

        // Vérifier si le dernier mot commence par `#`
        if (lastWord.startsWith("#")) {
            const query = lastWord.slice(1); // Supprimer le `#`
            showSuggestions(query);
        } else {
            userDropdown.classList.add("hidden");
        }
    });

    // Cacher la liste déroulante si on clique à l'extérieur
    document.addEventListener("click", (e) => {
        if (!userDropdown.contains(e.target) && e.target !== userInput) {
            userDropdown.classList.add("hidden");
        }
    });
</script>

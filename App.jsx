import React, { useState, useEffect, use } from 'react';
import './Menu.css';
import dataInitiales from './data.json'; 

const MenuItem = ({ label, active, onClick }) => {
    return (
        <li className={active ? 'menu-item active' : 'menu-item'} onClick={onClick}>
            {label}
        </li>
    );
};

const Menu = () => {
    const categories = ['Accueil', 'Les maladies', 'Parametrage'];

    // 1. Gestion de l'onglet actif avec persistance
    const [selectedIndex, setSelectedIndex] = useState(() => {
        const savedIndex = localStorage.getItem('menuIndex');
        return savedIndex !== null ? parseInt(savedIndex) : 0;
    });

    // 2. Gestion de la collection (chargement depuis le localStorage ou le JSON par défaut)
    const [maladies, setMaladies] = useState(() => {
        const sauvegardes = localStorage.getItem('maCollectionMaladies');
        return sauvegardes ? JSON.parse(sauvegardes) : dataInitiales;
    });

    // 3. États pour la navigation interne
    const [selectedCategorie, setSelectedCategorie] = useState(null); 
    const [selectedMaladie, setSelectedMaladie] = useState(null);

   // Sauvegarde automatique des changements (onglet et données)
    useEffect(() => {
        localStorage.setItem('menuIndex', selectedIndex);
        localStorage.setItem('maCollectionMaladies', JSON.stringify(maladies));
    }, [selectedIndex, maladies]);

    const listeCategories = [...new Set(maladies.map(m => m.categorie))];

    // FONCTION DE SUPPRESSION AVEC ANNULATION
    const supprimerMaladie = (id) => {
        const confirmation = window.confirm("Êtes-vous sûr de vouloir supprimer cette maladie ?");
        if (confirmation) {
            setMaladies(maladies.filter(m => m.id !== id));
            setSelectedMaladie(null);
            setModeEdition(false);
        }
    };
///////////////////////////////////////////////////////////////////::::::
    //Formulaire ajout maladie
    const [formulaire, setFormulaire] = useState({
        nom: '',
        categorie: '',
        symptomes: '',
        public_affecte: '',
        type_maladie: '',
        est_eteinte: false,
        survie: '',
        traitements: ''
    });

////////////////////////////////////////////////////////////////:://////    
    //modif de maladie
    const [modeEdition, setModeEdition] = useState(false);
    const [formEdition, setFormEdition] = useState({
    id: '',
    nom: '',
    categorie: '',
    symptomes: '',
    public_affecte: '',
    type_maladie: '',
    est_eteinte: false,
    survie: '',
    traitements: ''
});


    // FONCTION POUR REMETTRE LES MALADIES SUPPRIMÉES
    const restaurerDonnees = () => {
        if (window.confirm("Voulez-vous restaurer toutes les maladies supprimées ?")) {
            setMaladies(dataInitiales);
            setSelectedMaladie(null);
            setSelectedCategorie(null);
            setModeEdition(false);
            alert("La collection a été remise à zéro !");
        }
    };

    //Fonction modif de maladie
    const modifEdition = (maladie) => {
        setFormEdition({
            id: maladie.id,
            nom: maladie.nom,
            categorie: maladie.categorie,
            symptomes: maladie.symptomes.join(', '),
            public_affecte: maladie.public_affecte,
            type_maladie: maladie.type_maladie || '',
            est_eteinte: maladie.est_eteinte,
            survie: maladie.survie,
            traitements: maladie.traitements.join(', ')
        });
        setModeEdition(true);
    };

    const sauvegarderModification = (e) => {
        e.preventDefault();

        if (
            !formEdition.nom.trim() ||
            !formEdition.categorie.trim() ||
            !formEdition.symptomes.trim() ||
            !formEdition.public_affecte.trim() ||
            !formEdition.survie.trim() ||
            !formEdition.traitements.trim()
        ) {
            alert("Merci de remplir tous les champs obligatoires.");
            return;
        }

        const maladieModifiee = {
            ...selectedMaladie,
            id: formEdition.id,
            nom: formEdition.nom.trim(),
            categorie: formEdition.categorie.trim(),
            symptomes: formEdition.symptomes
                .split(',')
                .map(s => s.trim())
                .filter(Boolean),
            public_affecte: formEdition.public_affecte.trim(),
            type_maladie: formEdition.type_maladie.trim(),
            est_eteinte: formEdition.est_eteinte,
            survie: formEdition.survie.trim(),
            traitements: formEdition.traitements
                .split(',')
                .map(t => t.trim())
                .filter(Boolean),
        };
        //dessous = copilot,
        //setMaladies(maladies.map(m => m.id === maladieModifiee.id ? maladieModifiee : m));
        const nouvellesMaladies = maladies.map(m =>
            m.id === formEdition.id ? maladieModifiee : m);
        
            setMaladies(nouvellesMaladies);
        setSelectedMaladie(maladieModifiee);
        setModeEdition(false);
        alert("Maladie modifiée avec succès !");
    };

    // FONCTION POUR AJOUTER UNE MALADIE
    const ajouterMaladie = (e) => {
        e.preventDefault();

        if (
        !formulaire.nom.trim() ||
        !formulaire.categorie.trim() ||
        !formulaire.symptomes.trim() ||
        !formulaire.public_affecte.trim() ||
        !formulaire.type_maladie.trim() ||
        !formulaire.survie.trim() ||
        !formulaire.traitements.trim()
    ) {
        alert("Merci de remplir tous les champs obligatoires.");
        return;
    }

    const nouvelId = String(
        Math.max(...maladies.map(m => Number(m.id)), 0) + 1
    );

    const nouvelleMaladie = {
        id: nouvelId,
        nom: formulaire.nom.trim(),
        categorie: formulaire.categorie.trim(),
        symptomes: formulaire.symptomes
            .split(',')
            .map(s => s.trim())
            .filter(Boolean),
        public_affecte: formulaire.public_affecte.trim(),
        type_maladie: formulaire.type_maladie.trim(),
        est_eteinte: formulaire.est_eteinte,
        survie: formulaire.survie.trim(),
        traitements: formulaire.traitements
            .split(',')
            .map(t => t.trim())
            .filter(Boolean),
    };

    setMaladies([...maladies, nouvelleMaladie]);

    setFormulaire({
        nom: '',
        categorie: '',
        symptomes: '',
        public_affecte: '',
        type_maladie: '',
        est_eteinte: false,
        survie: '',
        traitements: '',
    });

    alert("Maladie ajoutée avec succès !");
};






    return (
        <div>
            {/* BARRE DE NAVIGATION */}
            <nav className="navbar">
                <ul className="menu-list">
                    {categories.map((cat, index) => (
                        <MenuItem
                            key={cat}
                            label={cat}
                            active={index === selectedIndex}
                            onClick={() => {
                                setSelectedIndex(index);
                                setSelectedCategorie(null);
                                setSelectedMaladie(null);
                            }}
                        />
                    ))}
                </ul>
            </nav>

            <div className="content-container">
                
                {/* --- PAGE ACCUEIL --- */}
                {selectedIndex === 0 && (
                    <div className="home-content">
                        <div className="maladies-moment">
                            <h2>Maladies du moment</h2>
                            <p><i>Voici l'état actuel des épidémies surveillées en Mars 2026 :</i></p>
                            <ul>
                                <li>Grippe saisonnière - 🟢 Niveau de base. L'epidémie est officiellement terminée en France métropolitaine depuis la fin février. Les indicateurs sont revenus à leur niveau normal.</li>
                                <li>Bronchiolite : 🟢 Niveau de base. La circulation du virus (VRS) est désormais très faible dans toutes les régions de l'Hexagone.</li>
                                <li>COVID-19 : 🟡 Vigilance faible. La circulation reste présente mais à des niveaux bas et stables. On observe cependant une surveillance accrue des eaux usées.</li>
                                <li>Gastro-entérite : 🟡 Activité modérée. Comme souvent au début du printemps, on observe des foyers locaux, mais pas d'épidémie nationale majeure.</li>
                            </ul>
                        </div>
                        <div className="maladies-moment">
                            <h2>Vigilance Infections à méningocoque</h2>
                            <p><i>Quelques cas isolés ont été signalés récemment (notamment en Normandie), incitant les autorités à rappeler l'importance de la vaccination.</i></p>
                        </div>
                        <div className="maladies-moment">
                            <h2>Attention : retour du pollen !</h2>
                            <p><i>Les allergies saisonnières reviennent avec leur lot de symptômes. N'oubliez pas de consulter un professionnel de santé si les symptômes persistent.</i></p>
                        </div>
                        <section className="health-tips">
                            <h3>Indications de santé</h3>
                            <p>Pour limiter la propagation des maladies actuelles, nous recommandons :</p>
                            <ul>
                                <li><b>Lavage des mains :</b> Essentiel pour freiner la gastro-entérite.</li>
                                <li><b>Aération :</b> Ouvrez les fenêtres 10 min par jour contre la rhinopharyngite.</li>
                                <li><b>Distanciation :</b> Portez un masque en cas de symptômes grippaux.</li>
                            </ul>
                        </section>
                        <section className="site-info">
                            <h2>À propos de notre plateforme</h2>
                            <p>
                                Ce site a été conçu pour offrir un suivi en temps réel de la situation sanitaire. 
                                Notre but est de centraliser les données sur la propagation des virus courants afin de 
                                permettre aux utilisateurs d'adapter leurs comportements et de protéger leurs proches.
                            </p>
                        </section>
                    </div>
                )}
               
                {/* --- PAGE LES MALADIES --- */}
                {selectedIndex === 1 && (
                    <div className="maladies-section">
                        {!selectedCategorie && !selectedMaladie && (
                            <>
                                <h2 className="title-serif">Choisir une spécialité</h2>
                                <div className="categories-grid">
                                    {listeCategories.map(cat => (
                                        <div key={cat} onClick={() => setSelectedCategorie(cat)} className="category-card">
                                            {cat}
                                        </div>
                                    ))}
                                </div>
                            </>
                        )}

                        {selectedCategorie && !selectedMaladie && (
                            <>
                                <button onClick={() => setSelectedCategorie(null)} className="back-button">
                                    ← Retour aux spécialités
                                </button>
                                <h2 className="title-serif">Maladies : {selectedCategorie}</h2>
                                <div className="categories-grid">
                                    {maladies.filter(m => m.categorie === selectedCategorie).map(m => (
                                        <div key={m.id} onClick={() => setSelectedMaladie(m)} className="maladie-item">
                                            <strong>{m.nom}</strong>
                                        </div>
                                    ))}
                                </div>
                            </>
                        )}

                        {selectedMaladie && (

                            <div className="maladie-detail-box">
                                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                                    {/* BOUTON RETOUR CLASSIQUE */}
                                    <button onClick={() => setSelectedMaladie(null)} className="back-button">
                                        ← Retour à la liste
                                    </button>

                                    {/* BOUTON MODIFIER STYLE RETOUR MAIS GRIS */}
                                    <button 
                                        onClick={() => 
                                            modifEdition(selectedMaladie)
                                            //modifEdition
                                            //setModeEdition(true);
                                            //setFormEdition(selectedMaladie);
                                        }
                                        className="back-button"
                                        style={{ backgroundColor: '#95a5a6', borderColor: '#7f8c8d', color: 'white' }}
                                    >
                                        Modifier cette maladie
                                    </button>

                                    {/* BOUTON SUPPRIMER STYLE RETOUR MAIS ROUGE */}
                                    <button 
                                        onClick={() => supprimerMaladie(selectedMaladie.id)} 
                                        className="back-button"
                                        style={{ backgroundColor: '#e74c3c', borderColor: '#c0392b', color: 'white' }}
                                    >
                                        Supprimer cette maladie
                                    </button>
                                </div>

                                {/*formulaire de modification*/}
                                {modeEdition && (   
                                <div className="admin_page">
                                    <h3>Modifier :{selectedMaladie.nom}</h3>
                                    <form onSubmit={sauvegarderModification} className="add-form" style={{ display: 'grid', gap: '15px', marginBottom: '30px' }}>
                                        <label>Nom de la maladie</label>
                                        <input
                                            type="text"
                                            value={formEdition.nom}
                                            onChange={(e) => setFormEdition({...formEdition, nom: e.target.value})}
                                        />
                                        <label>Catégorie</label>
                                        <input
                                            type="text"
                                            value={formEdition.categorie}
                                            onChange={(e) => setFormEdition({...formEdition, categorie: e.target.value})}
                                        />
                                        <label>Public affecté</label>
                                        <input
                                            type="text"
                                            value={formEdition.public_affecte}
                                            onChange={(e) => setFormEdition({...formEdition, public_affecte: e.target.value})}
                                        />
                                        <label>Survie</label>
                                        <input
                                            type="text"
                                            value={formEdition.survie}
                                            onChange={(e) => setFormEdition({...formEdition, survie: e.target.value})}
                                        />
                                        <label>Symptômes (séparés par des virgules)</label>
                                        <input
                                            type="text"
                                            value={formEdition.symptomes}
                                            onChange={(e) => setFormEdition({...formEdition, symptomes: e.target.value})}
                                        />
                                        <label>Traitements (séparés par des virgules)</label>
                                        <input
                                            type="text"
                                            value={formEdition.traitements}
                                            onChange={(e) => setFormEdition({...formEdition, traitements: e.target.value})}
                                        />
                                        <label style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                                            <input
                                                type="checkbox"
                                                checked={formEdition.est_eteinte}
                                                onChange={(e) => setFormEdition({...formEdition, est_eteinte: e.target.checked})}
                                            />
                                            Maladie éteinte
                                        </label>

                                        <div style={{ display: 'flex', gap: '15px' }}>
                                            <button
                                                type="submit"
                                                className="back-button"
                                                style={{ backgroundColor: '#2ecc71', borderColor: '#27ae60', color: 'white' }}
                                            >
                                                Sauvegarder les modifications
                                            </button>
                                            <button
                                                type="button"
                                                onClick={() => setModeEdition(false)}
                                                className="back-button"
                                                style={{ backgroundColor: '#95a5a6', borderColor: '#7f8c8d', color: 'white' }}
                                            >
                                                Annuler
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                )}

                                <h2 className="title-serif" style={{ fontSize: '2em', marginTop: '20px' }}>{selectedMaladie.nom}</h2>
                                
                                <div className="detail-content" style={{ textAlign: 'left', marginTop: '20px' }}>
                                    <div style={{ marginBottom: '15px' }}>
                                        <p><strong>Catégorie :</strong> {selectedMaladie.categorie}</p>
                                    </div>
                                    
                                    <div style={{ marginBottom: '15px' }}>
                                        <p><strong>Public affecté :</strong> {selectedMaladie.public_affecte}</p>
                                    </div>

                                    <div style={{ marginBottom: '25px' }}>
                                        <p><strong>Pronostic :</strong> {selectedMaladie.survie}</p>
                                    </div>

                                    <div className="symptoms-section" style={{ borderTop: '1px solid #eee', paddingTop: '15px' }}>
                                        <p><strong>Symptômes :</strong></p>
                                        <ul style={{ paddingLeft: '20px', marginTop: '10px' }}>
                                            {selectedMaladie.symptomes.map((s, idx) => <li key={idx}>{s}</li>)}
                                        </ul>
                                    </div>
                                </div>

                                <div className="info-highlight" style={{ marginTop: '30px' }}>
                                    <p><strong>Traitements recommandés :</strong> {selectedMaladie.traitements.join(', ')}</p>
                                </div>
                            </div>
                        )}
                    </div>
                )}

                {/* --- PAGE MODIFICATION --- */}
                {selectedIndex === 2 && (
                    <div className="admin-page">
                        <h2 className="title-serif">Paramétrage</h2>
                        <div className="maladies-moment" style={{ textAlign: 'left', padding: '40px' }}>
                            <h3>Ajouter une nouvelle maladie</h3>
                            <form onSubmit={ajouterMaladie} className="add-form" style={{ display: 'grid', gap: '15px'}}>
                                <input
                                    type="text"
                                    placeholder="Nom de la maladie"
                                    value={formulaire.nom}
                                    onChange={(e) => setFormulaire({...formulaire, nom: e.target.value})}
                                />

                                <input
                                    type="text"
                                    placeholder="Catégorie"
                                    value={formulaire.categorie}
                                    onChange={(e) => setFormulaire({...formulaire, categorie: e.target.value})}
                                />

                                <input
                                    type="text"
                                    placeholder="Public affecté"
                                    value={formulaire.public_affecte}
                                    onChange={(e) => setFormulaire({...formulaire, public_affecte: e.target.value})}
                                />

                                <input
                                    type="text"
                                    placeholder="Type de maladie"
                                    value={formulaire.type_maladie}
                                    onChange={(e) => setFormulaire({...formulaire, type_maladie: e.target.value})}
                                />

                                <input
                                    type="text"
                                    placeholder="Pronostic/Survie"
                                    value={formulaire.survie}
                                    onChange={(e) => setFormulaire({...formulaire, survie: e.target.value})}
                                />                                

                                <input
                                    type="text"
                                    placeholder="Symptômes (séparés par des virgules)"
                                    value={formulaire.symptomes}
                                    onChange={(e) => setFormulaire({...formulaire, symptomes: e.target.value})}
                                />

                                <input
                                    type="text"
                                    placeholder="Traitements (séparés par des virgules)"
                                    value={formulaire.traitements}
                                    onChange={(e) => setFormulaire({...formulaire, traitements: e.target.value})}
                                />

                                <label style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                                    <input
                                        type="checkbox"
                                        checked={formulaire.est_eteinte}
                                        onChange={(e) => setFormulaire({...formulaire, est_eteinte: e.target.checked})}
                                    />
                                    Maladie éteinte
                                </label>

                                <button
                                    type="submit"
                                    className="back-button"
                                    style={{ backgroundColor: '#2ecc71', borderColor: '#27ae60', color: 'white', width: 'fit-content' }}
                                >
                                    Ajouter la maladie
                                </button>
                            </form>
                        </div>

                        <div className="maladies-moment" style={{ textAlign: 'center', padding: '40px' }}>
                            <p>Vous avez supprimé des éléments par erreur ?</p>
                            <button 
                                onClick={restaurerDonnees} 
                                className="back-button" 
                                style={{ backgroundColor: '#87CEEB', borderColor: '#1a6d8c', color: '#1a6d8c' }}
                            >
                                Restaurer toutes les données 
                            </button>
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
};

export default Menu;
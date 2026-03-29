import React, { useState, useEffect } from 'react';
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
    const categories = ['Accueil', 'Les maladies', 'Modification des données'];

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
        }
    };

    // FONCTION POUR REMETTRE LES MALADIES SUPPRIMÉES
    const restaurerDonnees = () => {
        if (window.confirm("Voulez-vous restaurer toutes les maladies supprimées ?")) {
            setMaladies(dataInitiales);
            alert("La collection a été remise à zéro !");
        }
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
                                    
                                    {/* BOUTON SUPPRIMER STYLE RETOUR MAIS ROUGE */}
                                    <button 
                                        onClick={() => supprimerMaladie(selectedMaladie.id)} 
                                        className="back-button"
                                        style={{ backgroundColor: '#e74c3c', borderColor: '#c0392b', color: 'white' }}
                                    >
                                        Supprimer cette maladie
                                    </button>
                                </div>
                                
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
                        <h2 className="title-serif">Modification des données</h2>
                        <div className="maladies-moment" style={{ textAlign: 'left', padding: '40px' }}>
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
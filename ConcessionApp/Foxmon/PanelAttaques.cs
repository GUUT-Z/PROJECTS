using System;
using System.Collections.Generic;
using System.IO;
using projetFoxmon;

namespace projetFoxmon
{
    public class PanelAttaques
    {
        public List<Attaque> ListeAttaques { get; set; }

        public PanelAttaques()
        {
            ListeAttaques = new List<Attaque>();
            ChargerAttaques();
        }

        private void ChargerAttaques()
        {
            string chemin = "attaques.csv";

            if (!File.Exists(chemin))
            {
                Console.WriteLine("Fichier attaques introuvable.");
                return;
            }

            try
            {
                using (StreamReader sr = new StreamReader(chemin))
                {
                    sr.ReadLine(); // header

                    string ligne;
                    while ((ligne = sr.ReadLine()) != null)
                    {
                        string[] parts = ligne.Split(',');

                        if (parts.Length == 4)
                        {
                            string nom = parts[0];
                            string type = parts[1];

                            if (int.TryParse(parts[2], out int puissance) &&
                                int.TryParse(parts[3], out int precision))
                            {
                                ListeAttaques.Add(
                                    new Attaque(nom, type, puissance, precision)
                                );
                            }
                        }
                    }
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine($"Erreur chargement attaques : {ex.Message}");
            }
        }
    }
}
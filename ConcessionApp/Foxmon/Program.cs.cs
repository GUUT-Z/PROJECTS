using System;
using System.Collections.Generic;

namespace projetFoxmon
{
	public class Program
	{
		public static void Main()
		{
			Carte carte1 = new Carte();
			Dresseur joueur = new Dresseur("babacar", 1, 1);

			//chargement du panel
			PanelAttaques panel = new PanelAttaques();

			// 🔹 Création des Foxmon du joueur
			Foxmon fox1 = new RenardFeu("Pyrolion");
			Foxmon fox2 = new RenardEau("Aquafluff");
			Foxmon fox3 = new RenardPlante("Leafling");
			Foxmon fox4 = new RenardGlace("Frostrix");
			Foxmon fox5 = new RenardMetal("Ironfang");
			Foxmon fox6 = new RenardElectrique("Zippit");

			//Ajout
			fox1.Attaques(panel);
			fox2.Attaques(panel);
			fox3.Attaques(panel);
			fox4.Attaques(panel);
			fox5.Attaques(panel);
			fox6.Attaques(panel);

			joueur.AjouterSiPossible(fox1);
			joueur.AjouterSiPossible(fox2);
			joueur.AjouterSiPossible(fox3);
			joueur.AjouterSiPossible(fox4);
			joueur.AjouterSiPossible(fox5);
			joueur.AjouterSiPossible(fox6);

			Random rnd = new Random();

			// 🔹 Liste de Foxmon sauvages
			List<Foxmon> FoxmonsSauvages = new List<Foxmon>
			{
				new RenardFeu("Emberpaw"),
				new RenardEau("Bubbluff"),
				new RenardPlante("Spriggle"),
				new RenardRoche("Rockpaw"),
				new RenardElectrique("ZippitWild"),
				new RenardGlace("Glaciraptor"),
				new RenardSol("Terraquake")
			};

			Console.CursorVisible = false;

			bool enCombat = false;

			while (true)
			{
				Console.Clear();
				carte1.Afficher();

				Console.SetCursorPosition(joueur.X, joueur.Y);
				Console.Write('P');

				ConsoleKey key = Console.ReadKey(true).Key;

				int newX = joueur.X;
				int newY = joueur.Y;

				if (key == ConsoleKey.UpArrow) newY--;
				if (key == ConsoleKey.DownArrow) newY++;
				if (key == ConsoleKey.RightArrow) newX++;
				if (key == ConsoleKey.LeftArrow) newX--;

				if (carte1.EstTraversable(newX, newY))
				{
					joueur.X = newX;
					joueur.Y = newY;

					// 🔥 déclenchement combat
					if (carte1.EstHauteHerbe(newX, newY) && rnd.Next(100) < 50)
					{
						enCombat = true;
					}

					if (enCombat)
					{
						Console.Clear();

						Foxmon monFoxmon = joueur.PremierFoxmon();

						if (monFoxmon == null)
						{
							Console.WriteLine("Pas de Foxmon disponible !");
							Console.ReadKey(true);
							enCombat = false;
							continue;
						}

						// 🔹 création Foxmon sauvage
						Foxmon baseSauvage = FoxmonsSauvages[rnd.Next(FoxmonsSauvages.Count)];

						Foxmon foxmonsauvage = new Foxmon(
							baseSauvage.Nom,
							baseSauvage.PV,
							baseSauvage.PVM,
							baseSauvage.LVL,
							baseSauvage.Speed,
							baseSauvage.Degats,
							baseSauvage.TypeElementaire
						);

						// ✔ AJOUT attaque au sauvage
						foxmonsauvage.Attaques(panel);

						while (enCombat)
						{
							Console.Clear();

							Console.WriteLine($"Un {foxmonsauvage.Nom} sauvage apparaît !");
							Console.WriteLine($"Combat avec {monFoxmon.Nom}");
							Console.WriteLine();

							Console.WriteLine("A = Attaquer");
							Console.WriteLine("C = Capturer");
							Console.WriteLine("Espace = Fuir");

							ConsoleKey action = Console.ReadKey(true).Key;

							// 🔥 ATTAQUE
							if (action == ConsoleKey.A)
							{
								if (monFoxmon.AttaquesConnues != null &&
									monFoxmon.AttaquesConnues.Count > 0)
								{
									monFoxmon.Attaquer(
										foxmonsauvage,
										monFoxmon.AttaquesConnues[0]
									);
								}

								if (foxmonsauvage.PV <= 0)
								{
									Console.WriteLine($"{foxmonsauvage.Nom} est vaincu !");
									enCombat = false;
								}
								else
								{
									if (foxmonsauvage.AttaquesConnues != null &&
										foxmonsauvage.AttaquesConnues.Count > 0)
									{
										foxmonsauvage.Attaquer(
											monFoxmon,
											foxmonsauvage.AttaquesConnues[0]
										);
									}

									Console.WriteLine($"{monFoxmon.Nom} a {monFoxmon.PV} PV.");
								}
							}

							// 🟢 FUITE
							else if (action == ConsoleKey.Spacebar)
							{
								Console.WriteLine("Vous fuyez !");
								enCombat = false;
							}

							// 🟡 CAPTURE
							else if (action == ConsoleKey.C)
							{
								bool capture = joueur.Capturer(foxmonsauvage);

								if (capture)
								{
									Console.WriteLine($"Vous avez capturé {foxmonsauvage.Nom}");
									enCombat = false;
								}
							}

							Console.ReadKey(true);
						}

						enCombat = false;
					}
				}
			}
		}
	}
}